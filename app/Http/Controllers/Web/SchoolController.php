<?php

namespace App\Http\Controllers\Web;

use App\Forms\SchoolForm;
use App\Http\Controllers\Controller;
use App\Http\Library\Library;
use App\Models\School;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Yajra\DataTables\Facades\DataTables;

class SchoolController extends Controller
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
    public function index(Request $request)
    {
        $user = $request->user();
        if ($this->isAdmin($user) || $this->isOperator($user)) {
            $schools = School::withTrashed()->with('students')->with('user')->get();
            if ($request->ajax()) {
                return DataTables::of($schools)
                    ->addIndexColumn()
                    ->addColumn(
                        'action',
                        function ($school) {
                            return view('pages.schools._actions', compact('school'));
                        }
                    )
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('pages.schools.index', compact('schools'));
        }
        abort(403, "Access denied!");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = $request->user();
        if ($this->isAdmin($user)) {
            $form = $this->_getForm();
            return view('pages.schools.create', compact('form'));
        }
        abort(403, "Access denied!");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user();
        if ($this->isAdmin($user)) {
            $form = $this->_getForm();
            $form->redirectIfNotValid();
            $s = $this->_fillSchoolData($request);
            $s->save();
            return redirect()->route('school_index')
                ->with(
                    'success',
                    'School created successfully!'
                );
        }
        abort(403, "Access denied!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, School $school, int $id)
    {
        $a = $request->user();
        if ($this->isRecognized($a) || $a->id == $school->user->id) {
            $school = School::find($id);
            if (empty($school)) {
                $school = School::withTrashed()->find($id);
            }
            return view('pages.schools.details', compact('school'));
        }
        abort(403, "Access denied!");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, School $school, int $id)
    {
        $a = $request->user();
        if ($this->isAdmin($a) || $this->isDirector($a)) {
            $school = School::find($id);
            if (empty($school)) {
                $school = School::withTrashed()->find($id);
            }
            $form = $this->_getForm($school);
            return view('pages.schools.create', compact('form', 'school'));
        }
        abort(403, "Access denied!");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, School $school, int $id)
    {
        $a = $request->user();
        if ($this->isAdmin($a) || $this->isDirector($a)) {
            $school = School::find($id);
            $form = $this->_getForm($school);
            $form->redirectIfNotValid();
            $school = $this->_fillSchoolData($request, $school);
            $school->update();
            return redirect()->route('school_index')
                ->with(
                    'success',
                    'School updated successfully!'
                );
        }
        abort(403, "Access denied!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, School $school, int $id)
    {
        $a = $request->user();
        if ($this->isAdmin($a)) {
            $school = School::find($id);
            $school->delete();
            return redirect()->route('school_index')
                ->with(
                    'success',
                    'School deleted successfully!'
                );
        }
        abort(403, "Access denied!");
    }

    /**
     * Initialisation du formulaire
     *
     * @param \App\Models\School $school model de données du formulaire.
     *
     * @return $mixed
     */
    private function _getForm(?School $school = null): SchoolForm
    {
        $school = $school ?: new School();
        return $this->_formbuilder->create(
            SchoolForm::class,
            [
                'model' => $school
            ]
        );
    }

    /**
     * Remplir les infos venant de la requette
     *
     * @param \Illuminate\Http\Request $req  requette utilisateur
     * @param \App\Models\School         $school model
     *
     * @return \App\Models\School
     */
    private function _fillSchoolData(Request $req, ?School $school = null)
    {
        $school = $school ?: new School();
        $school->name = $req->name;
        $school->contact = $req->contact;
        $school->user_id = $req->user_id;
        $school->description = $req->description;
        return $school;
    }
}
