# Php InfoJobs API

This is a library to use easy-way the InfoJobs API; the official documentation describe how to use the API in SOAP, insted if you use this library is all easy, just insert the credentials and use php functions.

Official infojobs documentation: https://developer.infojobs.net/documentation/soap_operation_list-c/index.xhtml

Visit my blog to stay update for other libraries and new tips: https://angelopili.it

---

* [Init](#init)
* [Get the IDs](#get-the-ids)
* [Create Offer](#create-offer)
* [Edit offer](#edit-offer)
* [Enable offer](#enable-offer)
* [Disable offer](#disable-offer)
* [Erase offer](#erase-offer)

```php
/**
 * You may use .env to declare your credentials
 * 
    $ composer require vlucas/phpdotenv
 * 
 * 
    require './vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    define('BASE',$_ENV['BASE']);
    define('USERNAME',$_ENV['USERNAME']);
    define('PASSWORD',$_ENV['PASSWORD']);
    define('EMAIL',$_ENV['EMAIL']);
*/
```

# Init

```php
require './infojobs.php';

$infoJobs = new InfoJobs([
    'credentials' => [
        'base' => BASE,
        'username' => USERNAME,
        'password' => PASSWORD,
        'email' => EMAIL
    ],
    'json' => true, // To use json output, otherwise the response is a php Object
    'compact' => true
]);

$infoJobs->getAccessToken(); // Get the token: required to use next functions
```

---


# Get the IDs
```php
/**
 * About sectors
 */

// Job industry used by employers to classify job vacancy. For example: Legal, Medical, Sales, Marketing...
$infoJobs->getCategories()

// Sub Job industry, accept $id of industry parent
$infoJobs->getSubCategories($id)

// Business sector (art, architecture, etc).
$infoJobs->getIndustries()


/**
 * About contract
 */ 

// Type of contract between the employer and the employee (fixed-term, trainee, etc.).
$infoJobs->getContracts()

// Type of working day (full-time, part-time, etc.).
$infoJobs->getWorkingDays()

// The Career level of the candidate. For example, Entry level, manager, etc.
$infoJobs->getLaborLevel()



/**
 * About location
 */

// Comunity name (Barcelona, Andalucia, Abroad, etc).
$infoJobs->getComunities()

// Country of the job vacancy.
$infoJobs->getCountries()

// Provinces, accept $id of Comunity
$infoJobs->getProvinces($id)



/** 
 * About offer
 */

// Minimum required experience to be considered for the job.
$infoJobs->getMinExperience()

// The number of persons in charge
$infoJobs->getVacancies()

// Candidate residence requirement (Province where the offer is posted, country where the offer is posted, not appliable, etc.)
$infoJobs->getResidents()

// Monetary amount paid by the employer for a specified period.
$infoJobs->getSalary()

// Month, year, hour, week.
$infoJobs->getSalaryPeriod();

// Tipo url
$infoJobs->getUrlType()

// Willingness to make a change (Bad, depends on the conditions, etc).
$infoJobs->getDisponibilities()

// Level of expertise of the job seeker (High, Medium, ...).
$infoJobs->getSkillLevel()



/**
 * About studie
 * */
// Level of education of the job seeker (Bachelor's degree, Masters, etc.).
$infoJobs->getStudiesLevel()

// The parent list of values is the level of education.
$infoJobs->getSubStudies($id)



/**
 * About langs
 * */
// Level of proficiency for reading in a given language (Basic, Null, ...)
$infoJobs->getReadLevel()

// Level of proficiency for speaking a given language (Conversation, Null, ...)
$infoJobs->getSpokenLevel()

// Level of proficiency for writing in a given language (Conversation, Null, ...)
$infoJobs->getWrittenLevel()


/**
 * Others
 */

// Gender
$infoJobs->getSex()

// Type of driving licenses
$infoJobs->getDriveLicense()

// Language names (English, Spanish, etc).
$infoJobs->getLanguages()

```

---

# Create offer

```php
$infoJobs->createOffer([
    // Required fields
    'title'             => 'Senio Software Engineer with Java',
    'description'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...',
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
```

---

# Edit offer

```php
$infoJobs->editOffer([
    // Required fields
    'offerCode'         => '8343e746424bb7b6db2830aa7b9626',
    'city'              => 'Milan',
    'cap'               => 20125,
    'contractType'      => 12,
    'description'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...',
    'subindustry'       => 3107,
    'level'             => 2,
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
    'salaryBenefits' => 'Ticket restaurant 12',
    'speciality' => 413,
    'studying' => true,
    'timetable' => '9/18',
    'url' => 'https://www.candidate-personal-blog.it',
    'hideSalary' => false,
    'skills' => [
        'React.js', 'Laravel', 'Jenkins'
    ] 
]);
```

---

# Enable offer
```php
$infoJobs->enableOffer($offer_id);
```

---

# Disable offer
```php
$infoJobs->disableOffer($offer_id);
```

---

# Erase offer
```php
$infoJobs->eraseOffer($offer_id);
```

# Other funcionts

## findMyProfiles
Returns a list of the profiles of the current user that can use to publish job offers.

```php
$infoJobs->findMyProfiles();
```

## findOffers
Return a list of all your published offers
```php
$infoJobs->findOffers();
```