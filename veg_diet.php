<?php
require_once __DIR__ . '/includes/config.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['state'])) {
    header('Location: ' . BASE_URL . '/home.php');
    exit();
}

$state = $_SESSION['state'];

// Diet plans based on state (you can add more plans based on the provided data)
$diet_plans = [
    "Chhattisgarh" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Focus on rotis made from whole wheat, jowar, or bajra instead of calorie-dense rice.",
                "Include local vegetables such as spinach, fenugreek leaves, pumpkin, and cabbage in meals.",
                "Use light oils like groundnut oil or mustard oil sparingly.",
                "Incorporate boiled or steamed foods like mixed vegetable sabzi and replace fried snacks like poha and kachori."
            ],
            "Raw Materials" => [
                "Whole wheat", "jowar", "bajra", "spinach", "fenugreek", "pumpkin", "cabbage", "groundnut oil"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Increase the intake of ghee and butter in daily meals, particularly with rotis and parathas.",
                "Use calorie-dense ingredients like peanuts, jaggery, and sesame seeds in dishes like laddoos.",
                "Incorporate dairy products such as paneer, curd, and buttermilk.",
                "Include rich sweets like halwa made from semolina, wheat flour, and ghee."
            ],
            "Raw Materials" => [
                "Ghee", "butter", "peanuts", "jaggery", "paneer", "curd", "buttermilk", "semolina"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein dals like toor dal, chana dal, and moong dal, and include dairy products such as paneer and curd.",
                "Add soybeans, lentils, and legumes to meals for extra protein.",
                "Incorporate whole grains such as jowar, bajra, and wheat flour to boost carbohydrate intake.",
                "Add nuts and seeds like almonds, sunflower seeds, and flaxseeds for extra protein and fats."
            ],
            "Raw Materials" => [
                "Toor dal", "chana dal", "moong dal", "soybeans", "jowar", "bajra", "almonds", "sunflower seeds", "flaxseeds"
            ]
        ]
    ],
    "Madhya Pradesh" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Focus on rotis made from whole wheat, jowar, or bajra instead of calorie-dense rice.",
                "Include local vegetables such as spinach, fenugreek leaves, pumpkin, and cabbage in meals.",
                "Use light oils like groundnut oil or mustard oil sparingly.",
                "Incorporate boiled or steamed foods like mixed vegetable sabzi and replace fried snacks like poha and kachori."
            ],
            "Raw Materials" => [
                "Whole wheat", "jowar", "bajra", "spinach", "fenugreek", "pumpkin", "cabbage", "groundnut oil"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Increase the intake of ghee and butter in daily meals, particularly with rotis and parathas.",
                "Use calorie-dense ingredients like peanuts, jaggery, and sesame seeds in dishes like laddoos.",
                "Incorporate dairy products such as paneer, curd, and buttermilk.",
                "Include rich sweets like halwa made from semolina, wheat flour, and ghee."
            ],
            "Raw Materials" => [
                "Ghee", "butter", "peanuts", "jaggery", "paneer", "curd", "buttermilk", "semolina"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein dals like toor dal, chana dal, and moong dal, and include dairy products such as paneer and curd.",
                "Add soybeans, lentils, and legumes to meals for extra protein.",
                "Incorporate whole grains such as jowar, bajra, and wheat flour to boost carbohydrate intake.",
                "Add nuts and seeds like almonds, sunflower seeds, and flaxseeds for extra protein and fats."
            ],
            "Raw Materials" => [
                "Toor dal", "chana dal", "moong dal", "soybeans", "jowar", "bajra", "almonds", "sunflower seeds", "flaxseeds"
            ]
        ]
    ],
    "Uttar Pradesh" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Focus on rotis made from whole wheat, jowar, or bajra instead of calorie-dense rice.",
                "Include local vegetables such as spinach, fenugreek leaves, pumpkin, and cabbage in meals.",
                "Use light oils like groundnut oil or mustard oil sparingly.",
                "Incorporate boiled or steamed foods like mixed vegetable sabzi and replace fried snacks like poha and kachori."
            ],
            "Raw Materials" => [
                "Whole wheat", "jowar", "bajra", "spinach", "fenugreek", "pumpkin", "cabbage", "groundnut oil"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Increase the intake of ghee and butter in daily meals, particularly with rotis and parathas.",
                "Use calorie-dense ingredients like peanuts, jaggery, and sesame seeds in dishes like laddoos.",
                "Incorporate dairy products such as paneer, curd, and buttermilk.",
                "Include rich sweets like halwa made from semolina, wheat flour, and ghee."
            ],
            "Raw Materials" => [
                "Ghee", "butter", "peanuts", "jaggery", "paneer", "curd", "buttermilk", "semolina"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein dals like toor dal, chana dal, and moong dal, and include dairy products such as paneer and curd.",
                "Add soybeans, lentils, and legumes to meals for extra protein.",
                "Incorporate whole grains such as jowar, bajra, and wheat flour to boost carbohydrate intake.",
                "Add nuts and seeds like almonds, sunflower seeds, and flaxseeds for extra protein and fats."
            ],
            "Raw Materials" => [
                "Toor dal", "chana dal", "moong dal", "soybeans", "jowar", "bajra", "almonds", "sunflower seeds", "flaxseeds"
            ]
        ]
    ],
    "Uttaranchal" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Focus on rotis made from whole wheat, jowar, or bajra instead of calorie-dense rice.",
                "Include local vegetables such as spinach, fenugreek leaves, pumpkin, and cabbage in meals.",
                "Use light oils like groundnut oil or mustard oil sparingly.",
                "Incorporate boiled or steamed foods like mixed vegetable sabzi and replace fried snacks like poha and kachori."
            ],
            "Raw Materials" => [
                "Whole wheat", "jowar", "bajra", "spinach", "fenugreek", "pumpkin", "cabbage", "groundnut oil"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Increase the intake of ghee and butter in daily meals, particularly with rotis and parathas.",
                "Use calorie-dense ingredients like peanuts, jaggery, and sesame seeds in dishes like laddoos.",
                "Incorporate dairy products such as paneer, curd, and buttermilk.",
                "Include rich sweets like halwa made from semolina, wheat flour, and ghee."
            ],
            "Raw Materials" => [
                "Ghee", "butter", "peanuts", "jaggery", "paneer", "curd", "buttermilk", "semolina"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein dals like toor dal, chana dal, and moong dal, and include dairy products such as paneer and curd.",
                "Add soybeans, lentils, and legumes to meals for extra protein.",
                "Incorporate whole grains such as jowar, bajra, and wheat flour to boost carbohydrate intake.",
                "Add nuts and seeds like almonds, sunflower seeds, and flaxseeds for extra protein and fats."
            ],
            "Raw Materials" => [
                "Toor dal", "chana dal", "moong dal", "soybeans", "jowar", "bajra", "almonds", "sunflower seeds", "flaxseeds"
            ]
        ]
    ],
    "Bihar" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Replace regular rice with parboiled or unpolished rice to reduce calorie intake.",
                "Use mustard oil in moderation and focus on vegetables such as pumpkin, brinjal, radish, and leafy greens.",
                "Avoid fried snacks like pakoras and pithas; opt for boiled or steamed options like boiled vegetables and steamed pithas."
            ],
            "Raw Materials" => [
                "Parboiled rice", "mustard oil", "pumpkin", "brinjal", "radish", "leafy greens"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Incorporate calorie-dense foods such as jackfruit, bananas, and sweets like rasgulla and sandesh.",
                "Use more dairy products, including paneer, curd, and milk.",
                "Add high-calorie snacks such as kheer made with jaggery and ghee.",
                "Cook rice-based dishes with ghee for added richness and flavor."
            ],
            "Raw Materials" => [
                "Jackfruit", "bananas", "paneer", "ghee", "jaggery", "milk", "rasgulla ingredients"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein lentils such as moong dal, chana dal, and masoor dal.",
                "Include paneer and curd in meals as additional protein sources.",
                "Add whole grains like millet, oats, and buckwheat for complex carbohydrates.",
                "Incorporate nuts and seeds such as peanuts, sesame seeds, and sunflower seeds to increase protein intake."
            ],
            "Raw Materials" => [
                "Moong dal", "chana dal", "masoor dal", "paneer", "curd", "millet", "oats", "peanuts", "sesame seeds", "sunflower seeds"
            ]
        ]
    ],
    "Jharkhand" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Replace regular rice with parboiled or unpolished rice to reduce calorie intake.",
                "Use mustard oil in moderation and focus on vegetables such as pumpkin, brinjal, radish, and leafy greens.",
                "Avoid fried snacks like pakoras and pithas; opt for boiled or steamed options like boiled vegetables and steamed pithas."
            ],
            "Raw Materials" => [
                "Parboiled rice", "mustard oil", "pumpkin", "brinjal", "radish", "leafy greens"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Incorporate calorie-dense foods such as jackfruit, bananas, and sweets like rasgulla and sandesh.",
                "Use more dairy products, including paneer, curd, and milk.",
                "Add high-calorie snacks such as kheer made with jaggery and ghee.",
                "Cook rice-based dishes with ghee for added richness and flavor."
            ],
            "Raw Materials" => [
                "Jackfruit", "bananas", "paneer", "ghee", "jaggery", "milk", "rasgulla ingredients"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein lentils such as moong dal, chana dal, and masoor dal.",
                "Include paneer and curd in meals as additional protein sources.",
                "Add whole grains like millet, oats, and buckwheat for complex carbohydrates.",
                "Incorporate nuts and seeds such as peanuts, sesame seeds, and sunflower seeds to increase protein intake."
            ],
            "Raw Materials" => [
                "Moong dal", "chana dal", "masoor dal", "paneer", "curd", "millet", "oats", "peanuts", "sesame seeds", "sunflower seeds"
            ]
        ]
    ],
    "Orissa" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Replace regular rice with parboiled or unpolished rice to reduce calorie intake.",
                "Use mustard oil in moderation and focus on vegetables such as pumpkin, brinjal, radish, and leafy greens.",
                "Avoid fried snacks like pakoras and pithas; opt for boiled or steamed options like boiled vegetables and steamed pithas."
            ],
            "Raw Materials" => [
                "Parboiled rice", "mustard oil", "pumpkin", "brinjal", "radish", "leafy greens"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Incorporate calorie-dense foods such as jackfruit, bananas, and sweets like rasgulla and sandesh.",
                "Use more dairy products, including paneer, curd, and milk.",
                "Add high-calorie snacks such as kheer made with jaggery and ghee.",
                "Cook rice-based dishes with ghee for added richness and flavor."
            ],
            "Raw Materials" => [
                "Jackfruit", "bananas", "paneer", "ghee", "jaggery", "milk", "rasgulla ingredients"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein lentils such as moong dal, chana dal, and masoor dal.",
                "Include paneer and curd in meals as additional protein sources.",
                "Add whole grains like millet, oats, and buckwheat for complex carbohydrates.",
                "Incorporate nuts and seeds such as peanuts, sesame seeds, and sunflower seeds to increase protein intake."
            ],
            "Raw Materials" => [
                "Moong dal", "chana dal", "masoor dal", "paneer", "curd", "millet", "oats", "peanuts", "sesame seeds", "sunflower seeds"
            ]
        ]
    ],
    "West Bengal" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Replace regular rice with parboiled or unpolished rice to reduce calorie intake.",
                "Use mustard oil in moderation and focus on vegetables such as pumpkin, brinjal, radish, and leafy greens.",
                "Avoid fried snacks like pakoras and pithas; opt for boiled or steamed options like boiled vegetables and steamed pithas."
            ],
            "Raw Materials" => [
                "Parboiled rice", "mustard oil", "pumpkin", "brinjal", "radish", "leafy greens"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Incorporate calorie-dense foods such as jackfruit, bananas, and sweets like rasgulla and sandesh.",
                "Use more dairy products, including paneer, curd, and milk.",
                "Add high-calorie snacks such as kheer made with jaggery and ghee.",
                "Cook rice-based dishes with ghee for added richness and flavor."
            ],
            "Raw Materials" => [
                "Jackfruit", "bananas", "paneer", "ghee", "jaggery", "milk", "rasgulla ingredients"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein lentils such as moong dal, chana dal, and masoor dal.",
                "Include paneer and curd in meals as additional protein sources.",
                "Add whole grains like millet, oats, and buckwheat for complex carbohydrates.",
                "Incorporate nuts and seeds such as peanuts, sesame seeds, and sunflower seeds to increase protein intake."
            ],
            "Raw Materials" => [
                "Moong dal", "chana dal", "masoor dal", "paneer", "curd", "millet", "oats", "peanuts", "sesame seeds", "sunflower seeds"
            ]
        ]
    ],
    "Chandigarh" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Replace heavy gravies and fried snacks with chapati and lightly cooked sabzi made from local vegetables like spinach, fenugreek, carrots, and cauliflower.",
                "Use mustard oil or sunflower oil sparingly for cooking.",
                "Avoid rich, buttery dishes like paneer butter masala and opt for grilled or boiled vegetable preparations."
            ],
            "Raw Materials" => [
                "Wheat flour", "mustard oil", "sunflower oil", "spinach", "carrots", "fenugreek", "cauliflower"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use ghee and butter generously in rotis, parathas, and daily meals.",
                "Incorporate calorie-rich snacks like samosas, pakoras, and kachoris.",
                "Add dairy-based sweets such as kheer, halwa, and milk-based dishes like rabri.",
                "Use jaggery and sugar for sweet dishes to increase calorie intake."
            ],
            "Raw Materials" => [
                "Ghee", "butter", "paneer", "curd", "milk", "jaggery", "kheer", "rabri ingredients"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on protein-rich dals such as urad dal and chana dal.",
                "Include dairy products like paneer, curd, and lassi for protein.",
                "Add soybeans, tofu, and legumes to boost protein intake.",
                "Incorporate whole grains such as bajra and jowar to meet carbohydrate needs.",
                "Use nuts such as almonds, cashews, and peanuts for healthy fats."
            ],
            "Raw Materials" => [
                "Urad dal", "chana dal", "paneer", "curd", "soybeans", "bajra", "jowar", "almonds", "cashews", "peanuts"
            ]
        ]
    ],
    "Delhi" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Replace heavy gravies and fried snacks with chapati and lightly cooked sabzi made from local vegetables like spinach, fenugreek, carrots, and cauliflower.",
                "Use mustard oil or sunflower oil sparingly for cooking.",
                "Avoid rich, buttery dishes like paneer butter masala and opt for grilled or boiled vegetable preparations."
            ],
            "Raw Materials" => [
                "Wheat flour", "mustard oil", "sunflower oil", "spinach", "carrots", "fenugreek", "cauliflower"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use ghee and butter generously in rotis, parathas, and daily meals.",
                "Incorporate calorie-rich snacks like samosas, pakoras, and kachoris.",
                "Add dairy-based sweets such as kheer, halwa, and milk-based dishes like rabri.",
                "Use jaggery and sugar for sweet dishes to increase calorie intake."
            ],
            "Raw Materials" => [
                "Ghee", "butter", "paneer", "curd", "milk", "jaggery", "kheer", "rabri ingredients"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on protein-rich dals such as urad dal and chana dal.",
                "Include dairy products like paneer, curd, and lassi for protein.",
                "Add soybeans, tofu, and legumes to boost protein intake.",
                "Incorporate whole grains such as bajra and jowar to meet carbohydrate needs.",
                "Use nuts such as almonds, cashews, and peanuts for healthy fats."
            ],
            "Raw Materials" => [
                "Urad dal", "chana dal", "paneer", "curd", "soybeans", "bajra", "jowar", "almonds", "cashews", "peanuts"
            ]
        ]
    ],
    "Haryana" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Replace heavy gravies and fried snacks with chapati and lightly cooked sabzi made from local vegetables like spinach, fenugreek, carrots, and cauliflower.",
                "Use mustard oil or sunflower oil sparingly for cooking.",
                "Avoid rich, buttery dishes like paneer butter masala and opt for grilled or boiled vegetable preparations."
            ],
            "Raw Materials" => [
                "Wheat flour", "mustard oil", "sunflower oil", "spinach", "carrots", "fenugreek", "cauliflower"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use ghee and butter generously in rotis, parathas, and daily meals.",
                "Incorporate calorie-rich snacks like samosas, pakoras, and kachoris.",
                "Add dairy-based sweets such as kheer, halwa, and milk-based dishes like rabri.",
                "Use jaggery and sugar for sweet dishes to increase calorie intake."
            ],
            "Raw Materials" => [
                "Ghee", "butter", "paneer", "curd", "milk", "jaggery", "kheer", "rabri ingredients"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on protein-rich dals such as urad dal and chana dal.",
                "Include dairy products like paneer, curd, and lassi for protein.",
                "Add soybeans, tofu, and legumes to boost protein intake.",
                "Incorporate whole grains such as bajra and jowar to meet carbohydrate needs.",
                "Use nuts such as almonds, cashews, and peanuts for healthy fats."
            ],
            "Raw Materials" => [
                "Urad dal", "chana dal", "paneer", "curd", "soybeans", "bajra", "jowar", "almonds", "cashews", "peanuts"
            ]
        ]
    ],
    "Himachal Pradesh" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Replace heavy gravies and fried snacks with chapati and lightly cooked sabzi made from local vegetables like spinach, fenugreek, carrots, and cauliflower.",
                "Use mustard oil or sunflower oil sparingly for cooking.",
                "Avoid rich, buttery dishes like paneer butter masala and opt for grilled or boiled vegetable preparations."
            ],
            "Raw Materials" => [
                "Wheat flour", "mustard oil", "sunflower oil", "spinach", "carrots", "fenugreek", "cauliflower"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use ghee and butter generously in rotis, parathas, and daily meals.",
                "Incorporate calorie-rich snacks like samosas, pakoras, and kachoris.",
                "Add dairy-based sweets such as kheer, halwa, and milk-based dishes like rabri.",
                "Use jaggery and sugar for sweet dishes to increase calorie intake."
            ],
            "Raw Materials" => [
                "Ghee", "butter", "paneer", "curd", "milk", "jaggery", "kheer", "rabri ingredients"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on protein-rich dals such as urad dal and chana dal.",
                "Include dairy products like paneer, curd, and lassi for protein.",
                "Add soybeans, tofu, and legumes to boost protein intake.",
                "Incorporate whole grains such as bajra and jowar to meet carbohydrate needs.",
                "Use nuts such as almonds, cashews, and peanuts for healthy fats."
            ],
            "Raw Materials" => [
                "Urad dal", "chana dal", "paneer", "curd", "soybeans", "bajra", "jowar", "almonds", "cashews", "peanuts"
            ]
        ]
    ],
    "Jammu & Kashmir" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Replace heavy gravies and fried snacks with chapati and lightly cooked sabzi made from local vegetables like spinach, fenugreek, carrots, and cauliflower.",
                "Use mustard oil or sunflower oil sparingly for cooking.",
                "Avoid rich, buttery dishes like paneer butter masala and opt for grilled or boiled vegetable preparations."
            ],
            "Raw Materials" => [
                "Wheat flour", "mustard oil", "sunflower oil", "spinach", "carrots", "fenugreek", "cauliflower"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use ghee and butter generously in rotis, parathas, and daily meals.",
                "Incorporate calorie-rich snacks like samosas, pakoras, and kachoris.",
                "Add dairy-based sweets such as kheer, halwa, and milk-based dishes like rabri.",
                "Use jaggery and sugar for sweet dishes to increase calorie intake."
            ],
            "Raw Materials" => [
                "Ghee", "butter", "paneer", "curd", "milk", "jaggery", "kheer", "rabri ingredients"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on protein-rich dals such as urad dal and chana dal.",
                "Include dairy products like paneer, curd, and lassi for protein.",
                "Add soybeans, tofu, and legumes to boost protein intake.",
                "Incorporate whole grains such as bajra and jowar to meet carbohydrate needs.",
                "Use nuts such as almonds, cashews, and peanuts for healthy fats."
            ],
            "Raw Materials" => [
                "Urad dal", "chana dal", "paneer", "curd", "soybeans", "bajra", "jowar", "almonds", "cashews", "peanuts"
            ]
        ]
    ],
    "Punjab" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Replace heavy gravies and fried snacks with chapati and lightly cooked sabzi made from local vegetables like spinach, fenugreek, carrots, and cauliflower.",
                "Use mustard oil or sunflower oil sparingly for cooking.",
                "Avoid rich, buttery dishes like paneer butter masala and opt for grilled or boiled vegetable preparations."
            ],
            "Raw Materials" => [
                "Wheat flour", "mustard oil", "sunflower oil", "spinach", "carrots", "fenugreek", "cauliflower"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use ghee and butter generously in rotis, parathas, and daily meals.",
                "Incorporate calorie-rich snacks like samosas, pakoras, and kachoris.",
                "Add dairy-based sweets such as kheer, halwa, and milk-based dishes like rabri.",
                "Use jaggery and sugar for sweet dishes to increase calorie intake."
            ],
            "Raw Materials" => [
                "Ghee", "butter", "paneer", "curd", "milk", "jaggery", "kheer", "rabri ingredients"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on protein-rich dals such as urad dal and chana dal.",
                "Include dairy products like paneer, curd, and lassi for protein.",
                "Add soybeans, tofu, and legumes to boost protein intake.",
                "Incorporate whole grains such as bajra and jowar to meet carbohydrate needs.",
                "Use nuts such as almonds, cashews, and peanuts for healthy fats."
            ],
            "Raw Materials" => [
                "Urad dal", "chana dal", "paneer", "curd", "soybeans", "bajra", "jowar", "almonds", "cashews", "peanuts"
            ]
        ]
    ],
    "Ladakh" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Replace heavy gravies and fried snacks with chapati and lightly cooked sabzi made from local vegetables like spinach, fenugreek, carrots, and cauliflower.",
                "Use mustard oil or sunflower oil sparingly for cooking.",
                "Avoid rich, buttery dishes like paneer butter masala and opt for grilled or boiled vegetable preparations."
            ],
            "Raw Materials" => [
                "Wheat flour", "mustard oil", "sunflower oil", "spinach", "carrots", "fenugreek", "cauliflower"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use ghee and butter generously in rotis, parathas, and daily meals.",
                "Incorporate calorie-rich snacks like samosas, pakoras, and kachoris.",
                "Add dairy-based sweets such as kheer, halwa, and milk-based dishes like rabri.",
                "Use jaggery and sugar for sweet dishes to increase calorie intake."
            ],
            "Raw Materials" => [
                "Ghee", "butter", "paneer", "curd", "milk", "jaggery", "kheer", "rabri ingredients"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on protein-rich dals such as urad dal and chana dal.",
                "Include dairy products like paneer, curd, and lassi for protein.",
                "Add soybeans, tofu, and legumes to boost protein intake.",
                "Incorporate whole grains such as bajra and jowar to meet carbohydrate needs.",
                "Use nuts such as almonds, cashews, and peanuts for healthy fats."
            ],
            "Raw Materials" => [
                "Urad dal", "chana dal", "paneer", "curd", "soybeans", "bajra", "jowar", "almonds", "cashews", "peanuts"
            ]
        ]
    ],
    "Rajasthan" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Replace heavy gravies and fried snacks with chapati and lightly cooked sabzi made from local vegetables like spinach, fenugreek, carrots, and cauliflower.",
                "Use mustard oil or sunflower oil sparingly for cooking.",
                "Avoid rich, buttery dishes like paneer butter masala and opt for grilled or boiled vegetable preparations."
            ],
            "Raw Materials" => [
                "Wheat flour", "mustard oil", "sunflower oil", "spinach", "carrots", "fenugreek", "cauliflower"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use ghee and butter generously in rotis, parathas, and daily meals.",
                "Incorporate calorie-rich snacks like samosas, pakoras, and kachoris.",
                "Add dairy-based sweets such as kheer, halwa, and milk-based dishes like rabri.",
                "Use jaggery and sugar for sweet dishes to increase calorie intake."
            ],
            "Raw Materials" => [
                "Ghee", "butter", "paneer", "curd", "milk", "jaggery", "kheer", "rabri ingredients"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on protein-rich dals such as urad dal and chana dal.",
                "Include dairy products like paneer, curd, and lassi for protein.",
                "Add soybeans, tofu, and legumes to boost protein intake.",
                "Incorporate whole grains such as bajra and jowar to meet carbohydrate needs.",
                "Use nuts such as almonds, cashews, and peanuts for healthy fats."
            ],
            "Raw Materials" => [
                "Urad dal", "chana dal", "paneer", "curd", "soybeans", "bajra", "jowar", "almonds", "cashews", "peanuts"
            ]
        ]
    ],
    "Arunachal Pradesh" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Use black rice or sticky rice, which are lower in calories compared to regular white rice.",
                "Incorporate local vegetables such as bamboo shoots, yams, and leafy greens in meals.",
                "Replace mustard oil with lighter oils such as sunflower oil for a healthier cooking medium.",
                "Focus on boiled or steamed dishes like vegetable soups, salads, and stir-fries."
            ],
            "Raw Materials" => [
                "Black rice", "bamboo shoots", "sunflower oil", "yams", "leafy greens"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Increase the intake of calorie-dense ingredients such as sesame seeds, butter, and rice flour in daily meals.",
                "Incorporate sticky rice-based dishes, which are higher in calories and widely consumed in the Northeast.",
                "Add traditional snacks like boiled peanuts, sweet potatoes, and sesame seed-based sweets."
            ],
            "Raw Materials" => [
                "Sesame seeds", "butter", "sticky rice", "rice flour", "peanuts", "sweet potatoes"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein lentils like moong dal and chana dal, along with local beans and soy products.",
                "Use paneer and curd as dairy-based protein sources, along with fermented soybeans (axone).",
                "Incorporate complex carbohydrates like millet, brown rice, and buckwheat for energy.",
                "Include nuts such as peanuts and almonds for protein and healthy fats."
            ],
            "Raw Materials" => [
                "Moong dal", "chana dal", "paneer", "curd", "fermented soybeans", "millet", "brown rice", "peanuts", "almonds"
            ]
        ]
    ],
    "Assam" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Use black rice or sticky rice, which are lower in calories compared to regular white rice.",
                "Incorporate local vegetables such as bamboo shoots, yams, and leafy greens in meals.",
                "Replace mustard oil with lighter oils such as sunflower oil for a healthier cooking medium.",
                "Focus on boiled or steamed dishes like vegetable soups, salads, and stir-fries."
            ],
            "Raw Materials" => [
                "Black rice", "bamboo shoots", "sunflower oil", "yams", "leafy greens"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Increase the intake of calorie-dense ingredients such as sesame seeds, butter, and rice flour in daily meals.",
                "Incorporate sticky rice-based dishes, which are higher in calories and widely consumed in the Northeast.",
                "Add traditional snacks like boiled peanuts, sweet potatoes, and sesame seed-based sweets."
            ],
            "Raw Materials" => [
                "Sesame seeds", "butter", "sticky rice", "rice flour", "peanuts", "sweet potatoes"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein lentils like moong dal and chana dal, along with local beans and soy products.",
                "Use paneer and curd as dairy-based protein sources, along with fermented soybeans (axone).",
                "Incorporate complex carbohydrates like millet, brown rice, and buckwheat for energy.",
                "Include nuts such as peanuts and almonds for protein and healthy fats."
            ],
            "Raw Materials" => [
                "Moong dal", "chana dal", "paneer", "curd", "fermented soybeans", "millet", "brown rice", "peanuts", "almonds"
            ]
        ]
    ],
    "Manipur" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Use black rice or sticky rice, which are lower in calories compared to regular white rice.",
                "Incorporate local vegetables such as bamboo shoots, yams, and leafy greens in meals.",
                "Replace mustard oil with lighter oils such as sunflower oil for a healthier cooking medium.",
                "Focus on boiled or steamed dishes like vegetable soups, salads, and stir-fries."
            ],
            "Raw Materials" => [
                "Black rice", "bamboo shoots", "sunflower oil", "yams", "leafy greens"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Increase the intake of calorie-dense ingredients such as sesame seeds, butter, and rice flour in daily meals.",
                "Incorporate sticky rice-based dishes, which are higher in calories and widely consumed in the Northeast.",
                "Add traditional snacks like boiled peanuts, sweet potatoes, and sesame seed-based sweets."
            ],
            "Raw Materials" => [
                "Sesame seeds", "butter", "sticky rice", "rice flour", "peanuts", "sweet potatoes"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein lentils like moong dal and chana dal, along with local beans and soy products.",
                "Use paneer and curd as dairy-based protein sources, along with fermented soybeans (axone).",
                "Incorporate complex carbohydrates like millet, brown rice, and buckwheat for energy.",
                "Include nuts such as peanuts and almonds for protein and healthy fats."
            ],
            "Raw Materials" => [
                "Moong dal", "chana dal", "paneer", "curd", "fermented soybeans", "millet", "brown rice", "peanuts", "almonds"
            ]
        ]
    ],
    "Mizoram" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Use black rice or sticky rice, which are lower in calories compared to regular white rice.",
                "Incorporate local vegetables such as bamboo shoots, yams, and leafy greens in meals.",
                "Replace mustard oil with lighter oils such as sunflower oil for a healthier cooking medium.",
                "Focus on boiled or steamed dishes like vegetable soups, salads, and stir-fries."
            ],
            "Raw Materials" => [
                "Black rice", "bamboo shoots", "sunflower oil", "yams", "leafy greens"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Increase the intake of calorie-dense ingredients such as sesame seeds, butter, and rice flour in daily meals.",
                "Incorporate sticky rice-based dishes, which are higher in calories and widely consumed in the Northeast.",
                "Add traditional snacks like boiled peanuts, sweet potatoes, and sesame seed-based sweets."
            ],
            "Raw Materials" => [
                "Sesame seeds", "butter", "sticky rice", "rice flour", "peanuts", "sweet potatoes"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein lentils like moong dal and chana dal, along with local beans and soy products.",
                "Use paneer and curd as dairy-based protein sources, along with fermented soybeans (axone).",
                "Incorporate complex carbohydrates like millet, brown rice, and buckwheat for energy.",
                "Include nuts such as peanuts and almonds for protein and healthy fats."
            ],
            "Raw Materials" => [
                "Moong dal", "chana dal", "paneer", "curd", "fermented soybeans", "millet", "brown rice", "peanuts", "almonds"
            ]
        ]
    ],
    "Meghalaya" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Use black rice or sticky rice, which are lower in calories compared to regular white rice.",
                "Incorporate local vegetables such as bamboo shoots, yams, and leafy greens in meals.",
                "Replace mustard oil with lighter oils such as sunflower oil for a healthier cooking medium.",
                "Focus on boiled or steamed dishes like vegetable soups, salads, and stir-fries."
            ],
            "Raw Materials" => [
                "Black rice", "bamboo shoots", "sunflower oil", "yams", "leafy greens"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Increase the intake of calorie-dense ingredients such as sesame seeds, butter, and rice flour in daily meals.",
                "Incorporate sticky rice-based dishes, which are higher in calories and widely consumed in the Northeast.",
                "Add traditional snacks like boiled peanuts, sweet potatoes, and sesame seed-based sweets."
            ],
            "Raw Materials" => [
                "Sesame seeds", "butter", "sticky rice", "rice flour", "peanuts", "sweet potatoes"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein lentils like moong dal and chana dal, along with local beans and soy products.",
                "Use paneer and curd as dairy-based protein sources, along with fermented soybeans (axone).",
                "Incorporate complex carbohydrates like millet, brown rice, and buckwheat for energy.",
                "Include nuts such as peanuts and almonds for protein and healthy fats."
            ],
            "Raw Materials" => [
                "Moong dal", "chana dal", "paneer", "curd", "fermented soybeans", "millet", "brown rice", "peanuts", "almonds"
            ]
        ]
    ],
    "Nagaland" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Use black rice or sticky rice, which are lower in calories compared to regular white rice.",
                "Incorporate local vegetables such as bamboo shoots, yams, and leafy greens in meals.",
                "Replace mustard oil with lighter oils such as sunflower oil for a healthier cooking medium.",
                "Focus on boiled or steamed dishes like vegetable soups, salads, and stir-fries."
            ],
            "Raw Materials" => [
                "Black rice", "bamboo shoots", "sunflower oil", "yams", "leafy greens"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Increase the intake of calorie-dense ingredients such as sesame seeds, butter, and rice flour in daily meals.",
                "Incorporate sticky rice-based dishes, which are higher in calories and widely consumed in the Northeast.",
                "Add traditional snacks like boiled peanuts, sweet potatoes, and sesame seed-based sweets."
            ],
            "Raw Materials" => [
                "Sesame seeds", "butter", "sticky rice", "rice flour", "peanuts", "sweet potatoes"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein lentils like moong dal and chana dal, along with local beans and soy products.",
                "Use paneer and curd as dairy-based protein sources, along with fermented soybeans (axone).",
                "Incorporate complex carbohydrates like millet, brown rice, and buckwheat for energy.",
                "Include nuts such as peanuts and almonds for protein and healthy fats."
            ],
            "Raw Materials" => [
                "Moong dal", "chana dal", "paneer", "curd", "fermented soybeans", "millet", "brown rice", "peanuts", "almonds"
            ]
        ]
    ],
    "Sikkim" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Use black rice or sticky rice, which are lower in calories compared to regular white rice.",
                "Incorporate local vegetables such as bamboo shoots, yams, and leafy greens in meals.",
                "Replace mustard oil with lighter oils such as sunflower oil for a healthier cooking medium.",
                "Focus on boiled or steamed dishes like vegetable soups, salads, and stir-fries."
            ],
            "Raw Materials" => [
                "Black rice", "bamboo shoots", "sunflower oil", "yams", "leafy greens"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Increase the intake of calorie-dense ingredients such as sesame seeds, butter, and rice flour in daily meals.",
                "Incorporate sticky rice-based dishes, which are higher in calories and widely consumed in the Northeast.",
                "Add traditional snacks like boiled peanuts, sweet potatoes, and sesame seed-based sweets."
            ],
            "Raw Materials" => [
                "Sesame seeds", "butter", "sticky rice", "rice flour", "peanuts", "sweet potatoes"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein lentils like moong dal and chana dal, along with local beans and soy products.",
                "Use paneer and curd as dairy-based protein sources, along with fermented soybeans (axone).",
                "Incorporate complex carbohydrates like millet, brown rice, and buckwheat for energy.",
                "Include nuts such as peanuts and almonds for protein and healthy fats."
            ],
            "Raw Materials" => [
                "Moong dal", "chana dal", "paneer", "curd", "fermented soybeans", "millet", "brown rice", "peanuts", "almonds"
            ]
        ]
    ],
    "Tripura" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Use black rice or sticky rice, which are lower in calories compared to regular white rice.",
                "Incorporate local vegetables such as bamboo shoots, yams, and leafy greens in meals.",
                "Replace mustard oil with lighter oils such as sunflower oil for a healthier cooking medium.",
                "Focus on boiled or steamed dishes like vegetable soups, salads, and stir-fries."
            ],
            "Raw Materials" => [
                "Black rice", "bamboo shoots", "sunflower oil", "yams", "leafy greens"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Increase the intake of calorie-dense ingredients such as sesame seeds, butter, and rice flour in daily meals.",
                "Incorporate sticky rice-based dishes, which are higher in calories and widely consumed in the Northeast.",
                "Add traditional snacks like boiled peanuts, sweet potatoes, and sesame seed-based sweets."
            ],
            "Raw Materials" => [
                "Sesame seeds", "butter", "sticky rice", "rice flour", "peanuts", "sweet potatoes"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein lentils like moong dal and chana dal, along with local beans and soy products.",
                "Use paneer and curd as dairy-based protein sources, along with fermented soybeans (axone).",
                "Incorporate complex carbohydrates like millet, brown rice, and buckwheat for energy.",
                "Include nuts such as peanuts and almonds for protein and healthy fats."
            ],
            "Raw Materials" => [
                "Moong dal", "chana dal", "paneer", "curd", "fermented soybeans", "millet", "brown rice", "peanuts", "almonds"
            ]
        ]
    ],
    "Andaman & Nicobar Islands" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Replace rice with smaller portions of idli or dosa made from fermented rice batter to control calorie intake.",
                "Use coconut oil in small quantities or substitute with sesame or groundnut oil.",
                "Include steamed vegetables such as drumsticks, spinach, and ash gourd in meals.",
                "Avoid calorie-dense snacks like banana chips or murukku; opt for lighter snacks like boiled lentils or salads."
            ],
            "Raw Materials" => [
                "Idli rice", "coconut oil", "sesame oil", "drumsticks", "spinach", "ash gourd"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use coconut milk, ghee, and jaggery generously in dishes like sambar, rasam, and payasam.",
                "Add calorie-dense snacks like banana chips, jackfruit chips, and traditional sweets such as kozhukattai.",
                "Incorporate dairy products like curd, buttermilk, and paneer for additional protein and fat."
            ],
            "Raw Materials" => [
                "Coconut milk", "ghee", "banana chips", "jackfruit chips", "curd", "jaggery", "kozhukattai"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on protein-rich lentils such as toor dal and urad dal, commonly used in dishes like dosa, idli, and sambar.",
                "Add soy products and paneer to increase protein intake.",
                "Use complex carbohydrates such as millet (ragi) and brown rice to provide sustained energy for muscle recovery.",
                "Include nuts such as cashews and almonds for additional protein and healthy fats."
            ],
            "Raw Materials" => [
                "Toor dal", "urad dal", "soy products", "paneer", "millet (ragi)", "brown rice", "cashews", "almonds"
            ]
        ]
    ],
    "Andhra Pradesh" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Replace rice with smaller portions of idli or dosa made from fermented rice batter to control calorie intake.",
                "Use coconut oil in small quantities or substitute with sesame or groundnut oil.",
                "Include steamed vegetables such as drumsticks, spinach, and ash gourd in meals.",
                "Avoid calorie-dense snacks like banana chips or murukku; opt for lighter snacks like boiled lentils or salads."
            ],
            "Raw Materials" => [
                "Idli rice", "coconut oil", "sesame oil", "drumsticks", "spinach", "ash gourd"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use coconut milk, ghee, and jaggery generously in dishes like sambar, rasam, and payasam.",
                "Add calorie-dense snacks like banana chips, jackfruit chips, and traditional sweets such as kozhukattai.",
                "Incorporate dairy products like curd, buttermilk, and paneer for additional protein and fat."
            ],
            "Raw Materials" => [
                "Coconut milk", "ghee", "banana chips", "jackfruit chips", "curd", "jaggery", "kozhukattai"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on protein-rich lentils such as toor dal and urad dal, commonly used in dishes like dosa, idli, and sambar.",
                "Add soy products and paneer to increase protein intake.",
                "Use complex carbohydrates such as millet (ragi) and brown rice to provide sustained energy for muscle recovery.",
                "Include nuts such as cashews and almonds for additional protein and healthy fats."
            ],
            "Raw Materials" => [
                "Toor dal", "urad dal", "soy products", "paneer", "millet (ragi)", "brown rice", "cashews", "almonds"
            ]
        ]
    ],
    "Karnataka" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Replace rice with smaller portions of idli or dosa made from fermented rice batter to control calorie intake.",
                "Use coconut oil in small quantities or substitute with sesame or groundnut oil.",
                "Include steamed vegetables such as drumsticks, spinach, and ash gourd in meals.",
                "Avoid calorie-dense snacks like banana chips or murukku; opt for lighter snacks like boiled lentils or salads."
            ],
            "Raw Materials" => [
                "Idli rice", "coconut oil", "sesame oil", "drumsticks", "spinach", "ash gourd"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use coconut milk, ghee, and jaggery generously in dishes like sambar, rasam, and payasam.",
                "Add calorie-dense snacks like banana chips, jackfruit chips, and traditional sweets such as kozhukattai.",
                "Incorporate dairy products like curd, buttermilk, and paneer for additional protein and fat."
            ],
            "Raw Materials" => [
                "Coconut milk", "ghee", "banana chips", "jackfruit chips", "curd", "jaggery", "kozhukattai"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on protein-rich lentils such as toor dal and urad dal, commonly used in dishes like dosa, idli, and sambar.",
                "Add soy products and paneer to increase protein intake.",
                "Use complex carbohydrates such as millet (ragi) and brown rice to provide sustained energy for muscle recovery.",
                "Include nuts such as cashews and almonds for additional protein and healthy fats."
            ],
            "Raw Materials" => [
                "Toor dal", "urad dal", "soy products", "paneer", "millet (ragi)", "brown rice", "cashews", "almonds"
            ]
        ]
    ],
    "Kerala" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Replace rice with smaller portions of idli or dosa made from fermented rice batter to control calorie intake.",
                "Use coconut oil in small quantities or substitute with sesame or groundnut oil.",
                "Include steamed vegetables such as drumsticks, spinach, and ash gourd in meals.",
                "Avoid calorie-dense snacks like banana chips or murukku; opt for lighter snacks like boiled lentils or salads."
            ],
            "Raw Materials" => [
                "Idli rice", "coconut oil", "sesame oil", "drumsticks", "spinach", "ash gourd"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use coconut milk, ghee, and jaggery generously in dishes like sambar, rasam, and payasam.",
                "Add calorie-dense snacks like banana chips, jackfruit chips, and traditional sweets such as kozhukattai.",
                "Incorporate dairy products like curd, buttermilk, and paneer for additional protein and fat."
            ],
            "Raw Materials" => [
                "Coconut milk", "ghee", "banana chips", "jackfruit chips", "curd", "jaggery", "kozhukattai"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on protein-rich lentils such as toor dal and urad dal, commonly used in dishes like dosa, idli, and sambar.",
                "Add soy products and paneer to increase protein intake.",
                "Use complex carbohydrates such as millet (ragi) and brown rice to provide sustained energy for muscle recovery.",
                "Include nuts such as cashews and almonds for additional protein and healthy fats."
            ],
            "Raw Materials" => [
                "Toor dal", "urad dal", "soy products", "paneer", "millet (ragi)", "brown rice", "cashews", "almonds"
            ]
        ]
    ],
    "Lakshadweep" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Replace rice with smaller portions of idli or dosa made from fermented rice batter to control calorie intake.",
                "Use coconut oil in small quantities or substitute with sesame or groundnut oil.",
                "Include steamed vegetables such as drumsticks, spinach, and ash gourd in meals.",
                "Avoid calorie-dense snacks like banana chips or murukku; opt for lighter snacks like boiled lentils or salads."
            ],
            "Raw Materials" => [
                "Idli rice", "coconut oil", "sesame oil", "drumsticks", "spinach", "ash gourd"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use coconut milk, ghee, and jaggery generously in dishes like sambar, rasam, and payasam.",
                "Add calorie-dense snacks like banana chips, jackfruit chips, and traditional sweets such as kozhukattai.",
                "Incorporate dairy products like curd, buttermilk, and paneer for additional protein and fat."
            ],
            "Raw Materials" => [
                "Coconut milk", "ghee", "banana chips", "jackfruit chips", "curd", "jaggery", "kozhukattai"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on protein-rich lentils such as toor dal and urad dal, commonly used in dishes like dosa, idli, and sambar.",
                "Add soy products and paneer to increase protein intake.",
                "Use complex carbohydrates such as millet (ragi) and brown rice to provide sustained energy for muscle recovery.",
                "Include nuts such as cashews and almonds for additional protein and healthy fats."
            ],
            "Raw Materials" => [
                "Toor dal", "urad dal", "soy products", "paneer", "millet (ragi)", "brown rice", "cashews", "almonds"
            ]
        ]
    ],
    "Pondicherry" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Replace rice with smaller portions of idli or dosa made from fermented rice batter to control calorie intake.",
                "Use coconut oil in small quantities or substitute with sesame or groundnut oil.",
                "Include steamed vegetables such as drumsticks, spinach, and ash gourd in meals.",
                "Avoid calorie-dense snacks like banana chips or murukku; opt for lighter snacks like boiled lentils or salads."
            ],
            "Raw Materials" => [
                "Idli rice", "coconut oil", "sesame oil", "drumsticks", "spinach", "ash gourd"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use coconut milk, ghee, and jaggery generously in dishes like sambar, rasam, and payasam.",
                "Add calorie-dense snacks like banana chips, jackfruit chips, and traditional sweets such as kozhukattai.",
                "Incorporate dairy products like curd, buttermilk, and paneer for additional protein and fat."
            ],
            "Raw Materials" => [
                "Coconut milk", "ghee", "banana chips", "jackfruit chips", "curd", "jaggery", "kozhukattai"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on protein-rich lentils such as toor dal and urad dal, commonly used in dishes like dosa, idli, and sambar.",
                "Add soy products and paneer to increase protein intake.",
                "Use complex carbohydrates such as millet (ragi) and brown rice to provide sustained energy for muscle recovery.",
                "Include nuts such as cashews and almonds for additional protein and healthy fats."
            ],
            "Raw Materials" => [
                "Toor dal", "urad dal", "soy products", "paneer", "millet (ragi)", "brown rice", "cashews", "almonds"
            ]
        ]
    ],
    "Telangana" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Replace rice with smaller portions of idli or dosa made from fermented rice batter to control calorie intake.",
                "Use coconut oil in small quantities or substitute with sesame or groundnut oil.",
                "Include steamed vegetables such as drumsticks, spinach, and ash gourd in meals.",
                "Avoid calorie-dense snacks like banana chips or murukku; opt for lighter snacks like boiled lentils or salads."
            ],
            "Raw Materials" => [
                "Idli rice", "coconut oil", "sesame oil", "drumsticks", "spinach", "ash gourd"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use coconut milk, ghee, and jaggery generously in dishes like sambar, rasam, and payasam.",
                "Add calorie-dense snacks like banana chips, jackfruit chips, and traditional sweets such as kozhukattai.",
                "Incorporate dairy products like curd, buttermilk, and paneer for additional protein and fat."
            ],
            "Raw Materials" => [
                "Coconut milk", "ghee", "banana chips", "jackfruit chips", "curd", "jaggery", "kozhukattai"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on protein-rich lentils such as toor dal and urad dal, commonly used in dishes like dosa, idli, and sambar.",
                "Add soy products and paneer to increase protein intake.",
                "Use complex carbohydrates such as millet (ragi) and brown rice to provide sustained energy for muscle recovery.",
                "Include nuts such as cashews and almonds for additional protein and healthy fats."
            ],
            "Raw Materials" => [
                "Toor dal", "urad dal", "soy products", "paneer", "millet (ragi)", "brown rice", "cashews", "almonds"
            ]
        ]
    ],
    "Tamil Nadu" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Replace rice with smaller portions of idli or dosa made from fermented rice batter to control calorie intake.",
                "Use coconut oil in small quantities or substitute with sesame or groundnut oil.",
                "Include steamed vegetables such as drumsticks, spinach, and ash gourd in meals.",
                "Avoid calorie-dense snacks like banana chips or murukku; opt for lighter snacks like boiled lentils or salads."
            ],
            "Raw Materials" => [
                "Idli rice", "coconut oil", "sesame oil", "drumsticks", "spinach", "ash gourd"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use coconut milk, ghee, and jaggery generously in dishes like sambar, rasam, and payasam.",
                "Add calorie-dense snacks like banana chips, jackfruit chips, and traditional sweets such as kozhukattai.",
                "Incorporate dairy products like curd, buttermilk, and paneer for additional protein and fat."
            ],
            "Raw Materials" => [
                "Coconut milk", "ghee", "banana chips", "jackfruit chips", "curd", "jaggery", "kozhukattai"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on protein-rich lentils such as toor dal and urad dal, commonly used in dishes like dosa, idli, and sambar.",
                "Add soy products and paneer to increase protein intake.",
                "Use complex carbohydrates such as millet (ragi) and brown rice to provide sustained energy for muscle recovery.",
                "Include nuts such as cashews and almonds for additional protein and healthy fats."
            ],
            "Raw Materials" => [
                "Toor dal", "urad dal", "soy products", "paneer", "millet (ragi)", "brown rice", "cashews", "almonds"
            ]
        ]
    ],
    "Dadra & Nagar Haveli" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Replace wheat-based meals such as rotis and bhakris with lighter millet-based meals like bajra or jowar.",
                "Use ghee and groundnut oil sparingly for cooking.",
                "Incorporate local vegetables such as fenugreek leaves, ridge gourd, and bottle gourd in meals.",
                "Avoid fried snacks like dhokla and kachoris; opt for steamed or boiled dishes."
            ],
            "Raw Materials" => [
                "Bajra", "jowar", "fenugreek leaves", "ridge gourd", "bottle gourd", "groundnut oil"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Incorporate calorie-dense snacks such as dhokla, fafda, and kachoris, common in West Indian cuisine.",
                "Use dairy products such as ghee, butter, and paneer in meals to increase fat content.",
                "Include rich sweets such as basundi and shrikhand, which are prepared with sugar and milk.",
                "Use chickpea flour (besan) in snacks and sweets like laddoos to boost calorie intake."
            ],
            "Raw Materials" => [
                "Ghee", "butter", "paneer", "basundi ingredients", "besan", "laddoos", "dhokla"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on protein-rich dals and legumes like toor dal, moong dal, and chana dal.",
                "Use paneer and curd as primary protein sources alongside soybeans and tofu.",
                "Incorporate whole grains such as bajra and jowar for complex carbohydrates.",
                "Add nuts and seeds like peanuts and sesame seeds for healthy fats and additional protein."
            ],
            "Raw Materials" => [
                "Toor dal", "moong dal", "chana dal", "paneer", "curd", "soybeans", "bajra", "jowar", "peanuts", "sesame seeds"
            ]
        ]
    ],
    "Diu & Daman" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Replace wheat-based meals such as rotis and bhakris with lighter millet-based meals like bajra or jowar.",
                "Use ghee and groundnut oil sparingly for cooking.",
                "Incorporate local vegetables such as fenugreek leaves, ridge gourd, and bottle gourd in meals.",
                "Avoid fried snacks like dhokla and kachoris; opt for steamed or boiled dishes."
            ],
            "Raw Materials" => [
                "Bajra", "jowar", "fenugreek leaves", "ridge gourd", "bottle gourd", "groundnut oil"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Incorporate calorie-dense snacks such as dhokla, fafda, and kachoris, common in West Indian cuisine.",
                "Use dairy products such as ghee, butter, and paneer in meals to increase fat content.",
                "Include rich sweets such as basundi and shrikhand, which are prepared with sugar and milk.",
                "Use chickpea flour (besan) in snacks and sweets like laddoos to boost calorie intake."
            ],
            "Raw Materials" => [
                "Ghee", "butter", "paneer", "basundi ingredients", "besan", "laddoos", "dhokla"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on protein-rich dals and legumes like toor dal, moong dal, and chana dal.",
                "Use paneer and curd as primary protein sources alongside soybeans and tofu.",
                "Incorporate whole grains such as bajra and jowar for complex carbohydrates.",
                "Add nuts and seeds like peanuts and sesame seeds for healthy fats and additional protein."
            ],
            "Raw Materials" => [
                "Toor dal", "moong dal", "chana dal", "paneer", "curd", "soybeans", "bajra", "jowar", "peanuts", "sesame seeds"
            ]
        ]
    ],
    "Goa" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Replace wheat-based meals such as rotis and bhakris with lighter millet-based meals like bajra or jowar.",
                "Use ghee and groundnut oil sparingly for cooking.",
                "Incorporate local vegetables such as fenugreek leaves, ridge gourd, and bottle gourd in meals.",
                "Avoid fried snacks like dhokla and kachoris; opt for steamed or boiled dishes."
            ],
            "Raw Materials" => [
                "Bajra", "jowar", "fenugreek leaves", "ridge gourd", "bottle gourd", "groundnut oil"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Incorporate calorie-dense snacks such as dhokla, fafda, and kachoris, common in West Indian cuisine.",
                "Use dairy products such as ghee, butter, and paneer in meals to increase fat content.",
                "Include rich sweets such as basundi and shrikhand, which are prepared with sugar and milk.",
                "Use chickpea flour (besan) in snacks and sweets like laddoos to boost calorie intake."
            ],
            "Raw Materials" => [
                "Ghee", "butter", "paneer", "basundi ingredients", "besan", "laddoos", "dhokla"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on protein-rich dals and legumes like toor dal, moong dal, and chana dal.",
                "Use paneer and curd as primary protein sources alongside soybeans and tofu.",
                "Incorporate whole grains such as bajra and jowar for complex carbohydrates.",
                "Add nuts and seeds like peanuts and sesame seeds for healthy fats and additional protein."
            ],
            "Raw Materials" => [
                "Toor dal", "moong dal", "chana dal", "paneer", "curd", "soybeans", "bajra", "jowar", "peanuts", "sesame seeds"
            ]
        ]
    ], 
    "Gujarat" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Replace wheat-based meals such as rotis and bhakris with lighter millet-based meals like bajra or jowar.",
                "Use ghee and groundnut oil sparingly for cooking.",
                "Incorporate local vegetables such as fenugreek leaves, ridge gourd, and bottle gourd in meals.",
                "Avoid fried snacks like dhokla and kachoris; opt for steamed or boiled dishes."
            ],
            "Raw Materials" => [
                "Bajra", "jowar", "fenugreek leaves", "ridge gourd", "bottle gourd", "groundnut oil"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Incorporate calorie-dense snacks such as dhokla, fafda, and kachoris, common in West Indian cuisine.",
                "Use dairy products such as ghee, butter, and paneer in meals to increase fat content.",
                "Include rich sweets such as basundi and shrikhand, which are prepared with sugar and milk.",
                "Use chickpea flour (besan) in snacks and sweets like laddoos to boost calorie intake."
            ],
            "Raw Materials" => [
                "Ghee", "butter", "paneer", "basundi ingredients", "besan", "laddoos", "dhokla"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on protein-rich dals and legumes like toor dal, moong dal, and chana dal.",
                "Use paneer and curd as primary protein sources alongside soybeans and tofu.",
                "Incorporate whole grains such as bajra and jowar for complex carbohydrates.",
                "Add nuts and seeds like peanuts and sesame seeds for healthy fats and additional protein."
            ],
            "Raw Materials" => [
                "Toor dal", "moong dal", "chana dal", "paneer", "curd", "soybeans", "bajra", "jowar", "peanuts", "sesame seeds"
            ]
        ]
    ],
    "Maharashtra" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Replace wheat-based meals such as rotis and bhakris with lighter millet-based meals like bajra or jowar.",
                "Use ghee and groundnut oil sparingly for cooking.",
                "Incorporate local vegetables such as fenugreek leaves, ridge gourd, and bottle gourd in meals.",
                "Avoid fried snacks like dhokla and kachoris; opt for steamed or boiled dishes."
            ],
            "Raw Materials" => [
                "Bajra", "jowar", "fenugreek leaves", "ridge gourd", "bottle gourd", "groundnut oil"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Incorporate calorie-dense snacks such as dhokla, fafda, and kachoris, common in West Indian cuisine.",
                "Use dairy products such as ghee, butter, and paneer in meals to increase fat content.",
                "Include rich sweets such as basundi and shrikhand, which are prepared with sugar and milk.",
                "Use chickpea flour (besan) in snacks and sweets like laddoos to boost calorie intake."
            ],
            "Raw Materials" => [
                "Ghee", "butter", "paneer", "basundi ingredients", "besan", "laddoos", "dhokla"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on protein-rich dals and legumes like toor dal, moong dal, and chana dal.",
                "Use paneer and curd as primary protein sources alongside soybeans and tofu.",
                "Incorporate whole grains such as bajra and jowar for complex carbohydrates.",
                "Add nuts and seeds like peanuts and sesame seeds for healthy fats and additional protein."
            ],
            "Raw Materials" => [
                "Toor dal", "moong dal", "chana dal", "paneer", "curd", "soybeans", "bajra", "jowar", "peanuts", "sesame seeds"
            ]
        ]
    ],
];

// Get the diet plan for the selected state
$diet_plan = $diet_plans[$state] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vegetarian Diet Plan — Fitness Fusion</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 40%, #a5d6a7 70%, #81c784 100%);
            margin: 0; padding: 0 15px 30px;
            min-height: 100vh;
            display: flex; flex-direction: column; align-items: center;
            color: #333;
        }

        /* ── Navbar ──────────────────────────────────── */
        .navbar {
            position: sticky; top: 0; z-index: 100;
            width: 100%; display: flex; justify-content: space-between; align-items: center;
            padding: 14px 40px;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(14px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.06);
            margin-bottom: 25px;
        }
        .navbar .brand {
            font-size: 1.45rem; font-weight: 800; color: #2e7d32;
            text-decoration: none; letter-spacing: -0.5px;
            display: flex; align-items: center;
        }
        .navbar .brand img { height: 44px; width: auto; margin-right: 10px; }
        .navbar .brand span { color: #43a047; }
        .nav-center { display: flex; gap: 6px; align-items: center; }
        .nav-center a {
            text-decoration: none; font-weight: 500; font-size: 0.88rem;
            color: #666; padding: 8px 18px; border-radius: 30px;
            transition: all 0.25s;
        }
        .nav-center a:hover { color: #2e7d32; background: #e8f5e9; }
        .nav-center a.active {
            color: #fff; background: #2e7d32; font-weight: 600;
            box-shadow: 0 4px 12px rgba(46,125,50,0.25);
        }
        .nav-right { display: flex; align-items: center; gap: 16px; }
        .nav-right .greeting { font-size: 0.88rem; color: #777; font-weight: 400; }
        .nav-right .greeting strong { color: #333; font-weight: 600; }
        .nav-right a.logout-btn {
            background: transparent; color: #c62828; padding: 8px 22px;
            border: 2px solid #c62828; border-radius: 30px;
            text-decoration: none; font-weight: 600; font-size: 0.85rem;
            transition: all 0.3s;
        }
        .nav-right a.logout-btn:hover {
            background: #c62828; color: #fff; transform: translateY(-1px);
        }

        /* Container Styling */
        .container {
            max-width: 850px; width: 100%;
            background: #ffffff; padding: 40px 35px;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.06);
            text-align: center;
            margin-bottom: 30px;
        }

        h1 {
            font-size: 1.75rem; color: #1b5e20;
            margin-bottom: 8px; font-weight: 700;
        }

        .page-subtitle {
            font-size: 0.88rem; color: #999; margin-bottom: 25px; font-weight: 400;
        }

        .plan { margin-bottom: 40px; text-align: left; }

        .plan-title {
            font-size: 1.3rem; color: #2e7d32; font-weight: 700;
            margin-bottom: 20px;
            border-bottom: 3px solid #43a047; padding-bottom: 8px;
        }

        .dietary-changes {
            background: #e8f5e9; padding: 22px;
            border-left: 5px solid #2e7d32;
            border-radius: 14px; margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(46,125,50,0.08);
            transition: transform 0.3s;
        }
        .dietary-changes:hover { transform: translateY(-3px); }
        .dietary-changes h2 { font-size: 1.2rem; margin-bottom: 10px; color: #2e7d32; font-weight: 600; }
        .dietary-changes ul { padding-left: 20px; list-style-type: square; color: #333; line-height: 1.7; }

        .raw-materials {
            background: #FFF8E1; padding: 22px;
            border-left: 5px solid #FFB74D;
            border-radius: 14px;
            box-shadow: 0 4px 15px rgba(255,167,38,0.08);
            transition: transform 0.3s;
        }
        .raw-materials:hover { transform: translateY(-3px); }
        .raw-materials h2 { font-size: 1.2rem; margin-bottom: 10px; color: #FB8C00; font-weight: 600; }
        .raw-materials ul { padding-left: 20px; list-style-type: disc; color: #333; line-height: 1.7; }

        /* Bottom Actions */
        .bottom-actions {
            display: flex; justify-content: center; gap: 15px; flex-wrap: wrap;
            margin-top: 10px;
        }
        .bottom-actions a {
            display: inline-block; padding: 14px 38px;
            border-radius: 35px; text-decoration: none;
            font-weight: 600; font-size: 0.9rem; transition: all 0.3s;
        }
        .btn-primary {
            background: #2e7d32; color: #fff;
            box-shadow: 0 8px 25px rgba(46,125,50,0.35);
        }
        .btn-primary:hover {
            background: #1b5e20; transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(46,125,50,0.4);
        }
        .btn-outline {
            background: #fff; color: #2e7d32; border: 2px solid #2e7d32;
        }
        .btn-outline:hover {
            background: #2e7d32; color: #fff; transform: translateY(-3px);
        }

        @media (max-width: 768px) {
            .navbar { padding: 12px 16px; flex-wrap: wrap; gap: 10px; }
            .nav-center { order: 3; width: 100%; justify-content: center; gap: 4px;
                border-top: 1px solid #f0f0f0; padding-top: 10px; }
            .nav-center a { font-size: 0.8rem; padding: 6px 12px; }
            .nav-right .greeting { display: none; }
            .container { padding: 25px 20px; margin: 0 15px 30px; }
            h1 { font-size: 1.5rem; }
            .plan-title { font-size: 1.1rem; }
            .dietary-changes, .raw-materials { padding: 16px; }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="<?= BASE_URL ?>/dashboard/dashboard.php" class="brand"><img src="<?= ASSET_URL ?>/logo.png" alt="Logo">Fitness<span>Fusion</span></a>
    <div class="nav-center">
        <a href="<?= BASE_URL ?>/dashboard/dashboard.php">Dashboard</a>
        <a href="<?= BASE_URL ?>/metrics/save_results.php">Metrics</a>
        <a href="<?= BASE_URL ?>/metrics/results.php">Health Report</a>
        <a href="<?= BASE_URL ?>/diet/plan.php" class="active">Diet Plan</a>
        <a href="<?= BASE_URL ?>/exercise/plan.php">Exercise</a>
    </div>
    <div class="nav-right">
        <span class="greeting">Hi, <strong><?= htmlspecialchars($userName) ?></strong></span>
        <a href="<?= BASE_URL ?>/logout.php" class="logout-btn">Logout</a>
    </div>
</nav>

<div class="container">
    <h1>🥗 Vegetarian Diet Plan</h1>
    <p class="page-subtitle">Personalized nutrition guide for <?php echo htmlspecialchars($state); ?></p>

    <?php if ($diet_plan): ?>
        <?php foreach ($diet_plan as $goal => $details): ?>
            <div class="plan">
                <div class="plan-title"><?php echo htmlspecialchars($goal); ?></div>

                <div class="dietary-changes">
                    <h2>Dietary Changes</h2>
                    <ul>
                        <?php foreach ($details['Dietary Changes'] as $change): ?>
                            <li><?php echo htmlspecialchars($change); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="raw-materials">
                    <h2>Raw Materials</h2>
                    <ul>
                        <?php foreach ($details['Raw Materials'] as $material): ?>
                            <li><?php echo htmlspecialchars($material); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="color:#999; padding:30px 0;">Diet plan not available for the selected state.</p>
    <?php endif; ?>

    <div class="bottom-actions">
        <a href="<?= BASE_URL ?>/exercise/plan.php" class="btn-primary">View Exercise Plans</a>
        <a href="<?= BASE_URL ?>/metrics/save_results.php" class="btn-outline">Update Metrics</a>
    </div>
</div>

</body>
</html>
