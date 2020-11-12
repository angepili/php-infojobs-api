<?php

require './vendor/autoload.php';
require './infojobs.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

define('BASE',$_ENV['BASE']);
define('USERNAME',$_ENV['USERNAME']);
define('PASSWORD',$_ENV['PASSWORD']);
define('EMAIL',$_ENV['EMAIL']);

/**
 * Init
 */
$infoJobs = new InfoJobs([
    'credentials' => [
        'base' => BASE,
        'username' => USERNAME,
        'password' => PASSWORD,
        'email' => EMAIL
    ],
    'json' => true,
    'compact' => true
]);

$infoJobs->getAccessToken();


$offer = $infoJobs->createOffer([
    // Required fields
    'title'             => 'Senior Software Engineer with Java',
    'description'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus metus erat, consequat tempus tristique quis, scelerisque quis lectus. Ut nunc urna, scelerisque sed neque in, hendrerit posuere neque. Integer molestie, mauris vitae gravida egestas, eros neque posuere massa, non tincidunt tellus massa ut elit. Etiam a massa imperdiet, aliquet dui sit amet, commodo est. Proin fringilla massa in ipsum pretium varius. Morbi elementum aliquam mauris a laoreet. Mauris viverra ornare eros eleifend condimentum. Morbi et elit ut sem efficitur hendrerit in ac felis. Quisque ac orci et augue tempus gravida sit amet a dui. Aliquam finibus libero nec nisl sollicitudin blandit. Suspendisse non mollis lorem. Donec nec diam quis nisi luctus sagittis.',
    'level'             => 2,
    'country'           => 26,
    'province'          => 647,
    'city'              => 'Milan',
    'cap'               => 20125,
    'contractType'      => 12,
    'industry'          => 150,
    'subindustry'       => 3124,
    'experience'        => 6,
    'studies'           => 230,
    'vacancies'         => 1,
    'workingDay'        => 1,
    'salaryPer'         => 5,
    'salaryFrom'        => 140,
    'salaryTo'          => 150,

    // Optional fields
    'vacancies' => 2,
    'department' => 'Development',
    'desiredJobSkills' => 'Strong Java skills',
    'requiredSkills' => 'Basic english',
    'email' => 'candidate@gmail.com',
    'jobDuration' => '6/12 months',
    'staff' => 3,
    'nationality' => 26,
    'residenceIn' => 2,
    'salaryBenefits' => 'Ticket restaurant 12€',
    'speciality' => 413,
    'studying' => true,
    'timetable' => '9/18',
    'url' => 'https://www.candidate-personal-blog.it',
    'hideSalary' => false,
    'skills' => [
        'Linux', 'Java', 'Php'
    ]
]);

print( $offer );