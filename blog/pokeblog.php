<!-- SAVE AS: pokeblog.php -->

<?php

$memories = [
    [
        "title" => "Starting in Pallet Town",
        "content" => "I still remember turning on my Game Boy Advance after school and hearing that opening theme. Pallet Town felt small, quiet, and safe — like the beginning of something huge. Back then, choosing between Charmander, Squirtle, and Bulbasaur felt like the most important decision in the world.",
        "image" => "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/4.png"
    ],

    [
        "title" => "The SS Anne Experience",
        "content" => "The SS Anne wasn't just another location. It felt like an adventure. Battling trainers in tiny ship rooms, finally facing Gary again, and getting HM01 Cut from the captain after rubbing his back — somehow those moments are burned permanently into my memory.",
        "image" => "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/7.png"
    ],

    [
        "title" => "Lavender Town at Night",
        "content" => "Nothing in FireRed and LeafGreen hit harder emotionally than Lavender Town. The music, the ghost Pokémon, the Marowak story... as kids we didn't fully understand why it felt sad. As adults, we do.",
        "image" => "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/104.png"
    ],

    [
        "title" => "Becoming Champion",
        "content" => "Defeating the Elite Four felt like finishing a childhood journey. The rival becoming Champion before us made the ending even more personal. And hearing Professor Oak say, 'Congratulations' felt like we truly earned it.",
        "image" => "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/6.png"
    ]
];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Pokémon FireRed & LeafGreen Memories</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Press Start 2P', cursive;
            background: #d8f8d8;
            image-rendering: pixelated;
        }

        .pixel-border {
            border: 4px solid #1f2937;
            box-shadow:
                0 0 0 4px #ffffff,
                0 0 0 8px #1f2937;
        }

        .pokemon-bg {
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.85), rgba(255, 255, 255, 0.85));
            background-size: 200px;
        }

        .dialog-box {
            background: white;
            border: 4px solid black;
            box-shadow: 6px 6px 0px black;
        }


        ::-webkit-scrollbar {
            display: none;
        }
    </style>

<body class="pokemon-bg text-gray-900">

    <!-- HEADER -->
    <header class="bg-red-600 border-b-8 border-black py-6">
        <div class="max-w-5xl mx-auto px-5 text-center">

            <h1 class="text-yellow-300 text-2xl md:text-4xl leading-relaxed">
                Pokémon FireRed<br>
                & LeafGreen
            </h1>

            <p class="text-white text-xs md:text-sm mt-6 leading-loose">
                A tribute to childhood adventures in Kanto.
            </p>

        </div>
    </header>

    <!-- HERO -->
    <section class="max-w-5xl mx-auto px-5 py-10">

        <div class="dialog-box p-6 md:p-10 leading-loose bg-green-100">

            <div class="flex flex-col md:flex-row items-center gap-8">

                <img
                    src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/25.png"
                    class="w-48 h-48">

                <div>

                    <h2 class="text-lg md:text-2xl mb-6 text-red-600">
                        Dear FireRed & LeafGreen,
                    </h2>

                    <p class="text-[10px] md:text-xs leading-8">
                        Some games entertain us for a few weeks.
                        Others stay with us forever.
                        <br><br>

                        Pokémon FireRed and LeafGreen were more than remakes.
                        They were gateways into adventure, imagination,
                        friendship, and discovery.
                        <br><br>

                        For many of us, Kanto wasn't just a region.
                        It was a second home.
                    </p>

                </div>

            </div>

        </div>

    </section>

    <!-- BLOG POSTS -->
    <main class="max-w-5xl mx-auto px-5 pb-20">

        <div class="space-y-12">

            <?php foreach ($memories as $memory): ?>

                <article class="dialog-box bg-white p-6 md:p-8">

                    <div class="flex flex-col md:flex-row gap-8 items-center">

                        <div class="bg-red-100 p-5 pixel-border">
                            <img
                                src="<?= $memory['image'] ?>"
                                class="w-32 h-32">
                        </div>

                        <div class="flex-1">

                            <h2 class="text-red-600 text-sm md:text-lg mb-6 leading-relaxed">
                                <?= $memory['title'] ?>
                            </h2>

                            <p class="text-[10px] md:text-xs leading-8">
                                <?= $memory['content'] ?>
                            </p>

                        </div>

                    </div>

                </article>

            <?php endforeach; ?>

        </div>

    </main>

    <!-- FOOTER -->
    <footer class="bg-gray-900 border-t-8 border-black py-10">

        <div class="max-w-5xl mx-auto px-5 text-center">

            <p class="text-green-300 text-[10px] md:text-xs leading-loose">
                “The world of Pokémon and the memories connected to it
                never really leave us.”
            </p>

        </div>
    </footer>

</body>

</html>