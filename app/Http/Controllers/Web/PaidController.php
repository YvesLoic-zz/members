<?php

namespace App\Http\Controllers\Web;

use App\Forms\PaidForm;
use App\Http\Controllers\Controller;
use App\Http\Library\Library;
use App\Models\Paiement;
use App\Models\School;
use App\Models\Student;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

class PaidController extends Controller
{

    use Library;

    private $_formbuilder;
    private $code;

    /**
     * Constructeur par defaut du controlleur des users.
     *
     * @param \Kris\LaravelFormBuilder\FormBuilder $formBuilder demarreur de template
     */
    public function __construct(FormBuilder $formBuilder)
    {
        $this->_formbuilder = $formBuilder;
        $this->code = strtoupper(uniqid(time()));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, int $id)
    {
        $user = $request->user();
        $fees = array();
        if ($this->isAdmin($user)) {
            $fees = Paiement::all();
            return view('pages.fees.index', compact('fees'));
        } else if ($this->isDirector($user)) {
            $school = School::withTrashed()->find($id);
            if (!empty($school)) {
                $fees = Paiement::where('school_id', $school->id);
                return view('pages.fees.index', compact('fees'));
            }
            abort(404, "School not found");
        } else {
            abort(403, "Access Denied!");
        }
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
            $student = Student::withTrashed()->find($id);
            $form = $this->_getForm($this->code, $student, $user->id);
            return view('pages.fees.create', compact('form', 'student'));
        }
        abort(403, "Access denied!");
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
        if ($this->isAdmin($user)) {
            $student = Student::withTrashed()->with('school')->find($id);
            $form = $this->_getForm($this->code, $student, $user->id);
            $form->redirectIfNotValid();
            Paiement::create([
                'code' => $this->code,
                'amount' => $request->amount,
                'student_id' => $request->student_id,
                'user_id' => $request->user_id,
            ]);
            return redirect()->route('student_index', $student->school->id)
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
     * @param  \App\Models\Paiement  $paiement
     * @return \Illuminate\Http\Response
     */
    public function show(Paiement $paiement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Paiement  $paiement
     * @return \Illuminate\Http\Response
     */
    public function edit(Paiement $paiement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Paiement  $paiement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Paiement $paiement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Paiement  $paiement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paiement $paiement)
    {
        //
    }

    /**
     * Initialisation du formulaire
     *
     * @param \App\Models\Paiement $paid model de données du formulaire.
     *
     * @return $mixed
     */
    private function _getForm(string $code, Student $student, int $user, ?Paiement $paid = null): PaidForm
    {
        $paid = $paid ?: new Paiement();
        return $this->_formbuilder->create(
            PaidForm::class,
            [
                'model' => $paid
            ],
            [
                'code' => $code,
                'student' => $student,
                'user_id' => $user
            ]
        );
    }
}
