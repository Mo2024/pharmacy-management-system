<?php 

    //4 to 20 characters with only alphabet letters and 0 to 9
    $usernameReg = "/^[A-Za-z][A-Za-z0-9]{3,19}$/";
    $emailReg = "/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/";
    //At least one special character, one small letter, one capital letter and length is at least 8 characters
    $passwordReg = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
    $nameReg = "/^[A-Za-z]+(?:\s+[A-Za-z]+)+$/";
    $pnumberReg = "/^[0-9]{1,100}$/";
    $dateReg = "/^\d{4}\-(0?[1-9]|1[012])\-(0?[1-9]|[12][0-9]|3[01])$/";
    $userTypeReg = "/^(admin|manager|user)$/";
    $pcodeReg = "/^\d{6}$/";
    $qTypesReg = "/^(MCQ|FITB|TF)$/";
    $questionsReg = "/^[A-Za-z0-9\s?.,!'-]+$/";
    $answersReg = "/^[A-Za-z0-9\s?.,!'-]+$/";
    $marksReg = "/^[1-9][0-9]*$/";
    $titleReg = "/^(?:\b\w{1,15}\b\s?){1,3}$/";
    $timerReg = "/^(300|600|1200|1800|2400|3000|3600)$/";
    $noOfQuestionsReg = "/^[1-9]\d*$/";
    $descriptionReg = "/^(?=.*[a-zA-Z]).{1,100}$/";
    $roleReg = "/^(pharmacist|admin|patient)$/";
    $idReg = "/^\d+$/";
    $priceReg = '/^[-+]?[0-9]*\.?[0-9]+$/';

