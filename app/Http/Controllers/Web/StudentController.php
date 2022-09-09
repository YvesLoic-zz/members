<?php

namespace App\Http\Controllers\Web;

use App\Exports\StudentExport;
use App\Forms\StudentForm;
use App\Http\Controllers\Controller;
use App\Http\Library\Library;
use App\Imports\StudentImport;
use App\Models\School;
use App\Models\Student;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    use Library;

    private $_formbuilder;

    /**
     * Constructeur par defaut du controlleur des users.
     *
     * @param \Kris\LaravelFormBuilder\FormBuilder $formBuilder demarreur de template
     */
    public function __construct(FormBuilder $formBuilder)
    {
        $this->_formbuilder = $formBuilder;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, int $id)
    {
        $user = $request->user();
        if ($this->isRecognized($user)) {
            $students = Student::withTrashed()->with('school')->get();
            $school = School::withTrashed()->find($id);
            if ($request->ajax()) {
                return DataTables::of($students)
                    ->addIndexColumn()
                    ->addColumn(
                        'action',
                        function ($student) {
                            return view('pages.students._actions', compact('student'));
                        }
                    )
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('pages.students.index', compact('students', 'school'));
        }
        abort(403, 'Access denied!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, int $id)
    {
        $user = $request->user();
        if ($this->isAdmin($user) || $this->isDirector($user)) {
            $school = School::withTrashed()->find($id);
            $form = $this->_getForm($school->id);
            return view('pages.students.create', compact('form', 'school'));
        }
        abort(403, 'Access denied!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $id)
    {
        $user = $request->user();
        if ($this->isAdmin($user) || $this->isDirector($user)) {
            School::findOrFail($id) ?: abort(404, 'School not found!');
            $form = $this->_getForm($id);
            $form->redirectIfNotValid();
            $s = $this->_fillStudentData($request);
            $s->save();
            return redirect()->route('student_index', ['id' => $id])
                ->with(
                    'success',
                    'Student created successfully!'
                );
        }
        abort(403, 'Access denied!');
    }

    /**
     * Store newly student array created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkStore(Request $request, int $id)
    {
        $user = $request->user();
        if ($this->isRecognized($user)) {
            Excel::import(new StudentImport($id), $request->studFile);
            return redirect()->route('student_index', ['id' => $id])
                ->with(
                    'success',
                    'Students imported successfully!'
                );
        }
        abort(403, 'Access denied!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Student $student, string $id)
    {
        $user = $request->user();
        if ($this->isRecognized($user)) {
            $student = Student::find($id);
            if (empty($student)) {
                $student = Student::withTrashed()->find($id);
            }
            return view('pages.students.details', compact('student'));
        }
        abort(403, 'Access denied!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Student $student, int $id)
    {
        $user = $request->user();
        if ($this->isAdmin($user) || $this->isDirector($user)) {
            $student = Student::find($id);
            if (empty($student)) {
                $student = Student::withTrashed()->find($id);
            }
            $school = School::find($student->school_id);
            $form = $this->_getForm($id, $student);
            return view('pages.students.create', compact('form', 'student', 'school'));
        }
        abort(403, "Access denied!");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student, int $id)
    {
        $user = $request->user();
        if ($this->isAdmin($user) || $this->isDirector($user)) {
            $student = Student::find($id);
            $form = $this->_getForm($student);
            $form->redirectIfNotValid();
            $student = $this->_fillStudentData($request, $student);
            $student->update();
            return redirect()->route('student_index', ['id' => $student->school->id])
                ->with(
                    'success',
                    'Student updated successfully!'
                );
        }
        abort(403, "Access denied!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Student $student, int $id)
    {
        $a = $request->user();
        if ($this->isAdmin($a) || $this->isDirector($a)) {
            $student = Student::find($id);
            $student->delete();
            return redirect()->route('student_index', ['id' => $student->school->id])
                ->with(
                    'success',
                    'Student deleted successfully!'
                );
        }
        abort(403, "Access denied!");
    }

    /**
     * Initialisation du formulaire
     *
     * @param \App\Models\Student $student model de données du formulaire.
     *
     * @return $mixed
     */
    private function _getForm(int $id, ?Student $student = null): StudentForm
    {
        $student = $student ?: new Student();
        return $this->_formbuilder->create(
            StudentForm::class,
            [
                'model' => $student
            ],
            [
                'id' => $id
            ]
        );
    }

    /**
     * Remplir les infos venant de la requette
     *
     * @param \Illuminate\Http\Request $req  requette utilisateur
     * @param \App\Models\Student         $student model
     *
     * @return \App\Models\Student
     */
    private function _fillStudentData(Request $req, ?Student $student = null)
    {
        $student = $student ?: new Student();
        $student->matricule = $req->matricule;
        $student->first_name = $req->first_name;
        $student->last_name = $req->last_name;
        $student->class = $req->class;
        $student->birthday = $req->birthday;
        $student->birthplace = $req->birthplace;
        $student->sex = $req->sex;
        $student->school_id = $req->school_id;
        return $student;
    }

    /**
     *
     */
    public function exportStudent(Request $request, int $id)
    {
        $user = $request->user();
        if ($this->isRecognized($user)) {
            $school = School::findOrFail($id);
            if (!empty($school)) {
                return Excel::download(new StudentExport($school->id), '' . $school->name . '_studentsList.xlsx');
            }
            abort(404, "School datat not found!");
        }
        abort(403, "Access Denied!");
    }
}
