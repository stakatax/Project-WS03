<?php
$listings = [
    [
        'id' => 1,
        'title' => 'Software Engineer',
        'description' => 'We are looking for a professional Software Engineer to pioneer our system.',
        'salary' => 25000,
        'location' => 'San Francisco',
        'tags' => []
    ],

    [
        'id' => 2,
        'title' => 'Market Analyst',
        'description' => 'We are seeking an efficient Market Analyst to work in New York, USA.',
        'salary' => 18000,
        'location' => 'New York',
        'tags' => ['Market Analyst', 'Market', 'Trends']

    ],

    [
        'id' => 3,
        'title' => 'Design Specialist',
        'description' => 'We are looking for a skilled Design Specialist to engineer aesthetics for the team.',
        'salary' => 15000,
        'location' => 'Glendale',
        'tags' => ['Design Specialist', 'Design', 'Aesthetics', 'Graphics']
    ],

    [
        'id' => 4,
        'title' => 'Graphic Designer',
        'description' => 'We need a professional Graphic Designer with at least 2 years of experience in Adobe and/or other similar Illustration Programs.',
        'salary' => 15000,
        'location' => 'Nashville',
        'tags' => ['Graphic Design', 'Adobe Photoshop', 'Illustrator', 'Figma', 'Canva', 'Affinity']
    ],

    [
        'id' => 5,
        'title' => 'Security Engineer',
        'description' => 'We are seeking a skilled Security Engineer to provide maximum and efficient security for the system, database, and all important assets.',
        'salary' => 20000,
        'location' => 'Washington D.C.',
        'tags' => ['Security Engineer', 'Security']
    ]
];

/* Helper Function */

// function formatSalary($salary)
// {
//     return '$' . number_format($salary);
// }

$formatSalary = fn($salary) => '$' . number_format($salary);

// Anonymous Function

// $hello = function () {
//     echo "Hello";
// };

// $hello();

// Named Function

// function greet($name)
// {
//     return "Hello, " . $name;
// }

// Callback

// function greetUser($name, $callback)
// {
//     return $callback($name);
// }

// echo greetUser("Ron", "greet");

// use

// $name = "Ron";

// $greet = function () use ($name) {
//     echo "Hello, " . $name;
// };

// $greet();

function filterByLocation($listings, $location)
{
    return array_filter(
        $listings,
        function ($job) use ($location) {
            return strcasecmp($job['location'], $location) == 0;
        }
    );
}

if (isset($_GET['location'])) {
    $location = $_GET['location'];
    $filteredList = filterByLocation($listings, $location);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Special+Gothic+Condensed+One&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ["Montserrat", "ui-sans-serif"],
                    },
                },
            },
        };
    </script>
    <title>Job Listings</title>

    <style>
        body {
            overscroll-behavior: 0 0;
        }
    </style>
</head>

<body class="font-display bg-white">
    <header class="bg-blue-600 p-4 font-display text-white">
        <div class="container mx-auto">
            <h1 class="text-4xl font-black">Job Listings</h1>
        </div>
    </header>

    <div class="container mx-auto p-4 mt-4">
        <?php
        $filteredList = $filteredList ?? $listings;
        ?>
        <?php foreach ($filteredList as $index => $job): ?>

            <div class="md my-4">
                <div class="<?= $index % 2 === 0 ?
                                "bg-sky-100 rounded-lg shadow-md border border-sky-200 shadow-sky-800/30 " :
                                "bg-sky-50 rounded-lg shadow-md border border-sky-200 shadow-sky-600/30" ?>">
                    <div class="p-4">
                        <h2 class="font-display text-xl font-semibold"><?= $job['title'] ?></h2>
                        <p class="text-gray-700 text-lg font-light mt-2"><?= $job['description'] ?></p>

                        <ul class="mt-4">
                            <li class="mb-2">
                                <strong>Salary:</strong> <?= $formatSalary($job['salary']) ?>
                            </li>
                            <li class="mb-2">
                                <strong>Location:</strong> <?= $job['location'] ?>
                                <?= $job['location'] === 'New York' ?
                                    '<span class="inline-flex items-center px-2 py-1 ml-2 font-display font-semibold text-xs text-blue-600 bg-blue-200 border border-blue-600 rounded-full">Remote</span>' :
                                    '<span class="inline-flex items-center px-2 py-1 ml-2 font-display font-semibold text-xs text-sky-600 bg-sky-200 border border-sky-600 rounded-full">On-site</span>' ?>
                            </li>
                            <?php if (!empty($job['tags'])): ?>
                                <li class="mb-2">
                                    <strong>Tags:</strong> <?php foreach ($job['tags'] as $tag): ?> <span class="inline-flex font-semibold text-xs text-indigo-600 bg-indigo-200 border border-indigo-600 rounded-full px-2 py-1 ml-2"><?= $tag ?></span> <?php endforeach; ?>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>