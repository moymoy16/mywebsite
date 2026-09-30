<?php
namespace App\Controllers\Student;

use App\Core\Controller;
use App\Core\Middleware;
use App\Models\ProfileChangeRequest;
use App\Models\User;

class ProfileController extends Controller
{

 
    
    public function show(): void
    {
        Middleware::student();

        $userModel = new User();
        $profile   = $userModel->find((int)$_SESSION['user_id']);

        $requestModel = new ProfileChangeRequest();
        $requests     = $requestModel->forUser((int)$_SESSION['user_id']);

        $this->view('student/profile/show', [
            'title'    => 'My Profile',
            'profile'  => $profile,
            'requests' => $requests,
        ]);
    }

    public function edit(): void
    {
        Middleware::student();

        $profile = (new User())->find((int)$_SESSION['user_id']);

        $this->view('student/profile/edit', [
            'title'   => 'Request Profile Change',
            'profile' => $profile,
        ]);
    }

    public function submit(): void
    {
        Middleware::student();

        $userModel = new User();
        $profile   = $userModel->find((int)$_SESSION['user_id']);

        $reason = trim($_POST['reason'] ?? '');
        $errors = [];

        // Which fields the student is trying to change
        $fieldsToChange = [];
        $newValues      = [];

        $writable = [
            'name'       => 'Name',
            'email'      => 'Email',
            'student_id' => 'Student ID',
            'section'    => 'Section',
            'gender'     => 'Gender',
            'year_level' => 'Year Level',
            'age'        => 'Age',
        ];

        foreach ($writable as $field => $label) {
            $new = trim((string)($_POST[$field] ?? ''));
            $old = (string)($profile[$field] ?? '');

            if ($new !== '' && $new !== $old) {
                $fieldsToChange[] = $field;
                $newValues[$field] = ['old' => $old, 'new' => $new];
            }
        }

        if (empty($fieldsToChange)) {
            $errors[] = 'No changes were detected. Modify at least one field.';
        }

        if ($reason === '') {
            $errors[] = 'Please explain why you are requesting this change.';
        } elseif (mb_strlen($reason) < 10) {
            $errors[] = 'Please provide a bit more detail (at least 10 characters).';
        }

        // Proof image (optional but recommended)
        $proofImage = null;
        try {
            $proofImage = upload_profile_proof($_FILES['proof'] ?? []);
        } catch (\RuntimeException $e) {
            $errors[] = $e->getMessage();
        }

        if ($errors) {
            $this->view('student/profile/edit', [
                'title'   => 'Request Profile Change',
                'profile' => $profile,
                'errors'  => $errors,
                'old'     => $_POST,
            ]);
            return;
        }

        (new ProfileChangeRequest())->create(
            (int)$_SESSION['user_id'],
            $fieldsToChange,
            $newValues,
            $reason,
            $proofImage
        );

        $_SESSION['flash'] = 'Your change request has been submitted for review.';
        redirect('/profile');
    }
}