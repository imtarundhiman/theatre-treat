<?php 

return [
    /**
     * Mobile number should have 10 digits and start with any digit from [5-9]
     */
    'mobile' => "/^[56789]\d{9}$/",
    /**
     * Username must have minimum 5 and max 32 characters, 
     * start with a letter and must can have lowercase-letters and numbers
     */
    'username' => "/^[a-z][a-z0-9]{5,31}$/",
    /**
     * Password must have a capital character, 
     * a number and a special character and minimum 6 characters
     */
    'password' => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/",
    /**
     * Pincode regexes
     */
    'pincode' => [
        /**
         * pincode for india must have 6 digits and should not start with 0
         */
        'india' => "/^[1-9][0-9]{5}$/"
    ]
];

?>



