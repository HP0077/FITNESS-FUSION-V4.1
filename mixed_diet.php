<?php
require_once __DIR__ . '/includes/config.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['state'])) {
    header('Location: ' . BASE_URL . '/home.php');
    exit();
}

$state = $_SESSION['state'];

$diet_plans = [
    "Chhattisgarh" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Opt for lean meats like chicken and fish prepared in light curries or grilled.",
                "Use mustard oil sparingly for cooking.",
                "Include more fresh vegetables like tomatoes, cucumbers, and onions in salads.",
                "Avoid fried dishes like mutton samosas or kachoris."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "mustard oil", "tomatoes", "cucumbers", "onions"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use rich gravies and curries with mutton or goat meat cooked in ghee.",
                "Incorporate eggs and dairy products like paneer and curd in meals.",
                "Add rich snacks like pakoras, samosas, and rich curries.",
                "Include sweets like kheer and laddoos made with jaggery and ghee."
            ],
            "Raw Materials" => [
                "Mutton", "eggs", "paneer", "ghee", "jaggery", "kheer ingredients"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein meats like chicken, mutton, and eggs alongside protein-rich lentils like chana dal.",
                "Include soybeans, paneer, and curd for additional protein.",
                "Add nuts and seeds such as peanuts and cashews for healthy fats and protein."
            ],
            "Raw Materials" => [
                "Chicken", "mutton", "eggs", "chana dal", "peanuts", "cashews", "soybeans"
            ]
        ]
    ],
    "Madhya Pradesh" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Opt for lean meats like chicken and fish prepared in light curries or grilled.",
                "Use mustard oil sparingly for cooking.",
                "Include more fresh vegetables like tomatoes, cucumbers, and onions in salads.",
                "Avoid fried dishes like mutton samosas or kachoris."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "mustard oil", "tomatoes", "cucumbers", "onions"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use rich gravies and curries with mutton or goat meat cooked in ghee.",
                "Incorporate eggs and dairy products like paneer and curd in meals.",
                "Add rich snacks like pakoras, samosas, and rich curries.",
                "Include sweets like kheer and laddoos made with jaggery and ghee."
            ],
            "Raw Materials" => [
                "Mutton", "eggs", "paneer", "ghee", "jaggery", "kheer ingredients"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein meats like chicken, mutton, and eggs alongside protein-rich lentils like chana dal.",
                "Include soybeans, paneer, and curd for additional protein.",
                "Add nuts and seeds such as peanuts and cashews for healthy fats and protein."
            ],
            "Raw Materials" => [
                "Chicken", "mutton", "eggs", "chana dal", "peanuts", "cashews", "soybeans"
            ]
        ]
    ],
    "Uttar Pradesh" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Opt for lean meats like chicken and fish prepared in light curries or grilled.",
                "Use mustard oil sparingly for cooking.",
                "Include more fresh vegetables like tomatoes, cucumbers, and onions in salads.",
                "Avoid fried dishes like mutton samosas or kachoris."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "mustard oil", "tomatoes", "cucumbers", "onions"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use rich gravies and curries with mutton or goat meat cooked in ghee.",
                "Incorporate eggs and dairy products like paneer and curd in meals.",
                "Add rich snacks like pakoras, samosas, and rich curries.",
                "Include sweets like kheer and laddoos made with jaggery and ghee."
            ],
            "Raw Materials" => [
                "Mutton", "eggs", "paneer", "ghee", "jaggery", "kheer ingredients"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein meats like chicken, mutton, and eggs alongside protein-rich lentils like chana dal.",
                "Include soybeans, paneer, and curd for additional protein.",
                "Add nuts and seeds such as peanuts and cashews for healthy fats and protein."
            ],
            "Raw Materials" => [
                "Chicken", "mutton", "eggs", "chana dal", "peanuts", "cashews", "soybeans"
            ]
        ]
    ],
    "Uttaranchal" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Opt for lean meats like chicken and fish prepared in light curries or grilled.",
                "Use mustard oil sparingly for cooking.",
                "Include more fresh vegetables like tomatoes, cucumbers, and onions in salads.",
                "Avoid fried dishes like mutton samosas or kachoris."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "mustard oil", "tomatoes", "cucumbers", "onions"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use rich gravies and curries with mutton or goat meat cooked in ghee.",
                "Incorporate eggs and dairy products like paneer and curd in meals.",
                "Add rich snacks like pakoras, samosas, and rich curries.",
                "Include sweets like kheer and laddoos made with jaggery and ghee."
            ],
            "Raw Materials" => [
                "Mutton", "eggs", "paneer", "ghee", "jaggery", "kheer ingredients"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein meats like chicken, mutton, and eggs alongside protein-rich lentils like chana dal.",
                "Include soybeans, paneer, and curd for additional protein.",
                "Add nuts and seeds such as peanuts and cashews for healthy fats and protein."
            ],
            "Raw Materials" => [
                "Chicken", "mutton", "eggs", "chana dal", "peanuts", "cashews", "soybeans"
            ]
        ]
    ],
    "Bihar" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Use lean meats like fish (hilsa, rohu) and chicken, grilled or cooked in light curries.",
                "Include fresh vegetables like spinach, gourds, and tomatoes in daily meals.",
                "Use mustard oil sparingly and avoid heavy fried dishes like fish fry or chicken pakora."
            ],
            "Raw Materials" => [
                "Fish (hilsa, rohu)", "chicken", "spinach", "tomatoes", "mustard oil"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use calorie-dense foods like mutton or goat in rich gravies cooked in ghee and mustard oil.",
                "Incorporate traditional sweets like sandesh and rasgulla.",
                "Add dairy products such as paneer and curd for protein and fat.",
                "Include calorie-dense snacks like pithas and traditional fish curries with rice."
            ],
            "Raw Materials" => [
                "Mutton", "paneer", "ghee", "mustard oil", "sandesh ingredients"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on protein-rich meats like chicken and fish along with eggs for muscle recovery.",
                "Use legumes such as chana dal and soybeans for additional plant-based proteins.",
                "Include whole grains like brown rice and millet for complex carbohydrates.",
                "Add nuts and seeds like peanuts and almonds for protein and healthy fats."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "eggs", "chana dal", "soybeans", "brown rice", "almonds"
            ]
        ]
    ],
    "Jharkhand" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Use lean meats like fish (hilsa, rohu) and chicken, grilled or cooked in light curries.",
                "Include fresh vegetables like spinach, gourds, and tomatoes in daily meals.",
                "Use mustard oil sparingly and avoid heavy fried dishes like fish fry or chicken pakora."
            ],
            "Raw Materials" => [
                "Fish (hilsa, rohu)", "chicken", "spinach", "tomatoes", "mustard oil"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use calorie-dense foods like mutton or goat in rich gravies cooked in ghee and mustard oil.",
                "Incorporate traditional sweets like sandesh and rasgulla.",
                "Add dairy products such as paneer and curd for protein and fat.",
                "Include calorie-dense snacks like pithas and traditional fish curries with rice."
            ],
            "Raw Materials" => [
                "Mutton", "paneer", "ghee", "mustard oil", "sandesh ingredients"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on protein-rich meats like chicken and fish along with eggs for muscle recovery.",
                "Use legumes such as chana dal and soybeans for additional plant-based proteins.",
                "Include whole grains like brown rice and millet for complex carbohydrates.",
                "Add nuts and seeds like peanuts and almonds for protein and healthy fats."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "eggs", "chana dal", "soybeans", "brown rice", "almonds"
            ]
        ]
    ],
    "Orissa" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Use lean meats like fish (hilsa, rohu) and chicken, grilled or cooked in light curries.",
                "Include fresh vegetables like spinach, gourds, and tomatoes in daily meals.",
                "Use mustard oil sparingly and avoid heavy fried dishes like fish fry or chicken pakora."
            ],
            "Raw Materials" => [
                "Fish (hilsa, rohu)", "chicken", "spinach", "tomatoes", "mustard oil"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use calorie-dense foods like mutton or goat in rich gravies cooked in ghee and mustard oil.",
                "Incorporate traditional sweets like sandesh and rasgulla.",
                "Add dairy products such as paneer and curd for protein and fat.",
                "Include calorie-dense snacks like pithas and traditional fish curries with rice."
            ],
            "Raw Materials" => [
                "Mutton", "paneer", "ghee", "mustard oil", "sandesh ingredients"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on protein-rich meats like chicken and fish along with eggs for muscle recovery.",
                "Use legumes such as chana dal and soybeans for additional plant-based proteins.",
                "Include whole grains like brown rice and millet for complex carbohydrates.",
                "Add nuts and seeds like peanuts and almonds for protein and healthy fats."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "eggs", "chana dal", "soybeans", "brown rice", "almonds"
            ]
        ]
    ],
    "Bengal" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Use lean meats like fish (hilsa, rohu) and chicken, grilled or cooked in light curries.",
                "Include fresh vegetables like spinach, gourds, and tomatoes in daily meals.",
                "Use mustard oil sparingly and avoid heavy fried dishes like fish fry or chicken pakora."
            ],
            "Raw Materials" => [
                "Fish (hilsa, rohu)", "chicken", "spinach", "tomatoes", "mustard oil"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use calorie-dense foods like mutton or goat in rich gravies cooked in ghee and mustard oil.",
                "Incorporate traditional sweets like sandesh and rasgulla.",
                "Add dairy products such as paneer and curd for protein and fat.",
                "Include calorie-dense snacks like pithas and traditional fish curries with rice."
            ],
            "Raw Materials" => [
                "Mutton", "paneer", "ghee", "mustard oil", "sandesh ingredients"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on protein-rich meats like chicken and fish along with eggs for muscle recovery.",
                "Use legumes such as chana dal and soybeans for additional plant-based proteins.",
                "Include whole grains like brown rice and millet for complex carbohydrates.",
                "Add nuts and seeds like peanuts and almonds for protein and healthy fats."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "eggs", "chana dal", "soybeans", "brown rice", "almonds"
            ]
        ]
    ],
    "Chandigarh" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Opt for lean meats like chicken and fish prepared with light spices.",
                "Grill or bake meats instead of frying, and avoid heavy gravies.",
                "Use fresh vegetables like spinach, cauliflower, and cabbage in meals.",
                "Use mustard oil or sunflower oil sparingly."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "mustard oil", "spinach", "cauliflower", "cabbage"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use calorie-dense meats like mutton or goat cooked in rich gravies with ghee and butter.",
                "Incorporate eggs and dairy products like paneer and curd for additional protein and fat.",
                "Add traditional North Indian snacks like pakoras, samosas, and rich gravies with rice.",
                "Include rich sweets like laddoos and halwa made with ghee and sugar."
            ],
            "Raw Materials" => [
                "Mutton", "eggs", "paneer", "ghee", "butter", "laddoos", "halwa ingredients"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein meats like chicken, mutton, and fish along with eggs.",
                "Use protein-rich legumes like chana dal and soybeans for added plant-based protein.",
                "Include whole grains like millet and oats for complex carbohydrates.",
                "Add nuts and seeds like peanuts and sesame seeds for additional protein and fats."
            ],
            "Raw Materials" => [
                "Chicken", "mutton", "fish", "eggs", "chana dal", "millet", "oats", "peanuts", "sesame seeds"
            ]
        ]
    ],
    "Delhi" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Opt for lean meats like chicken and fish prepared with light spices.",
                "Grill or bake meats instead of frying, and avoid heavy gravies.",
                "Use fresh vegetables like spinach, cauliflower, and cabbage in meals.",
                "Use mustard oil or sunflower oil sparingly."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "mustard oil", "spinach", "cauliflower", "cabbage"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use calorie-dense meats like mutton or goat cooked in rich gravies with ghee and butter.",
                "Incorporate eggs and dairy products like paneer and curd for additional protein and fat.",
                "Add traditional North Indian snacks like pakoras, samosas, and rich gravies with rice.",
                "Include rich sweets like laddoos and halwa made with ghee and sugar."
            ],
            "Raw Materials" => [
                "Mutton", "eggs", "paneer", "ghee", "butter", "laddoos", "halwa ingredients"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein meats like chicken, mutton, and fish along with eggs.",
                "Use protein-rich legumes like chana dal and soybeans for added plant-based protein.",
                "Include whole grains like millet and oats for complex carbohydrates.",
                "Add nuts and seeds like peanuts and sesame seeds for additional protein and fats."
            ],
            "Raw Materials" => [
                "Chicken", "mutton", "fish", "eggs", "chana dal", "millet", "oats", "peanuts", "sesame seeds"
            ]
        ]
    ],
    "Haryana" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Opt for lean meats like chicken and fish prepared with light spices.",
                "Grill or bake meats instead of frying, and avoid heavy gravies.",
                "Use fresh vegetables like spinach, cauliflower, and cabbage in meals.",
                "Use mustard oil or sunflower oil sparingly."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "mustard oil", "spinach", "cauliflower", "cabbage"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use calorie-dense meats like mutton or goat cooked in rich gravies with ghee and butter.",
                "Incorporate eggs and dairy products like paneer and curd for additional protein and fat.",
                "Add traditional North Indian snacks like pakoras, samosas, and rich gravies with rice.",
                "Include rich sweets like laddoos and halwa made with ghee and sugar."
            ],
            "Raw Materials" => [
                "Mutton", "eggs", "paneer", "ghee", "butter", "laddoos", "halwa ingredients"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein meats like chicken, mutton, and fish along with eggs.",
                "Use protein-rich legumes like chana dal and soybeans for added plant-based protein.",
                "Include whole grains like millet and oats for complex carbohydrates.",
                "Add nuts and seeds like peanuts and sesame seeds for additional protein and fats."
            ],
            "Raw Materials" => [
                "Chicken", "mutton", "fish", "eggs", "chana dal", "millet", "oats", "peanuts", "sesame seeds"
            ]
        ]
    ],
    "Himachal Pradesh" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Opt for lean meats like chicken and fish prepared with light spices.",
                "Grill or bake meats instead of frying, and avoid heavy gravies.",
                "Use fresh vegetables like spinach, cauliflower, and cabbage in meals.",
                "Use mustard oil or sunflower oil sparingly."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "mustard oil", "spinach", "cauliflower", "cabbage"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use calorie-dense meats like mutton or goat cooked in rich gravies with ghee and butter.",
                "Incorporate eggs and dairy products like paneer and curd for additional protein and fat.",
                "Add traditional North Indian snacks like pakoras, samosas, and rich gravies with rice.",
                "Include rich sweets like laddoos and halwa made with ghee and sugar."
            ],
            "Raw Materials" => [
                "Mutton", "eggs", "paneer", "ghee", "butter", "laddoos", "halwa ingredients"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein meats like chicken, mutton, and fish along with eggs.",
                "Use protein-rich legumes like chana dal and soybeans for added plant-based protein.",
                "Include whole grains like millet and oats for complex carbohydrates.",
                "Add nuts and seeds like peanuts and sesame seeds for additional protein and fats."
            ],
            "Raw Materials" => [
                "Chicken", "mutton", "fish", "eggs", "chana dal", "millet", "oats", "peanuts", "sesame seeds"
            ]
        ]
    ],
    "Jammu & Kashmir" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Opt for lean meats like chicken and fish prepared with light spices.",
                "Grill or bake meats instead of frying, and avoid heavy gravies.",
                "Use fresh vegetables like spinach, cauliflower, and cabbage in meals.",
                "Use mustard oil or sunflower oil sparingly."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "mustard oil", "spinach", "cauliflower", "cabbage"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use calorie-dense meats like mutton or goat cooked in rich gravies with ghee and butter.",
                "Incorporate eggs and dairy products like paneer and curd for additional protein and fat.",
                "Add traditional North Indian snacks like pakoras, samosas, and rich gravies with rice.",
                "Include rich sweets like laddoos and halwa made with ghee and sugar."
            ],
            "Raw Materials" => [
                "Mutton", "eggs", "paneer", "ghee", "butter", "laddoos", "halwa ingredients"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein meats like chicken, mutton, and fish along with eggs.",
                "Use protein-rich legumes like chana dal and soybeans for added plant-based protein.",
                "Include whole grains like millet and oats for complex carbohydrates.",
                "Add nuts and seeds like peanuts and sesame seeds for additional protein and fats."
            ],
            "Raw Materials" => [
                "Chicken", "mutton", "fish", "eggs", "chana dal", "millet", "oats", "peanuts", "sesame seeds"
            ]
        ]
    ],
    "Punjab" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Opt for lean meats like chicken and fish prepared with light spices.",
                "Grill or bake meats instead of frying, and avoid heavy gravies.",
                "Use fresh vegetables like spinach, cauliflower, and cabbage in meals.",
                "Use mustard oil or sunflower oil sparingly."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "mustard oil", "spinach", "cauliflower", "cabbage"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use calorie-dense meats like mutton or goat cooked in rich gravies with ghee and butter.",
                "Incorporate eggs and dairy products like paneer and curd for additional protein and fat.",
                "Add traditional North Indian snacks like pakoras, samosas, and rich gravies with rice.",
                "Include rich sweets like laddoos and halwa made with ghee and sugar."
            ],
            "Raw Materials" => [
                "Mutton", "eggs", "paneer", "ghee", "butter", "laddoos", "halwa ingredients"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein meats like chicken, mutton, and fish along with eggs.",
                "Use protein-rich legumes like chana dal and soybeans for added plant-based protein.",
                "Include whole grains like millet and oats for complex carbohydrates.",
                "Add nuts and seeds like peanuts and sesame seeds for additional protein and fats."
            ],
            "Raw Materials" => [
                "Chicken", "mutton", "fish", "eggs", "chana dal", "millet", "oats", "peanuts", "sesame seeds"
            ]
        ]
    ],
    "Ladakh" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Opt for lean meats like chicken and fish prepared with light spices.",
                "Grill or bake meats instead of frying, and avoid heavy gravies.",
                "Use fresh vegetables like spinach, cauliflower, and cabbage in meals.",
                "Use mustard oil or sunflower oil sparingly."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "mustard oil", "spinach", "cauliflower", "cabbage"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use calorie-dense meats like mutton or goat cooked in rich gravies with ghee and butter.",
                "Incorporate eggs and dairy products like paneer and curd for additional protein and fat.",
                "Add traditional North Indian snacks like pakoras, samosas, and rich gravies with rice.",
                "Include rich sweets like laddoos and halwa made with ghee and sugar."
            ],
            "Raw Materials" => [
                "Mutton", "eggs", "paneer", "ghee", "butter", "laddoos", "halwa ingredients"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein meats like chicken, mutton, and fish along with eggs.",
                "Use protein-rich legumes like chana dal and soybeans for added plant-based protein.",
                "Include whole grains like millet and oats for complex carbohydrates.",
                "Add nuts and seeds like peanuts and sesame seeds for additional protein and fats."
            ],
            "Raw Materials" => [
                "Chicken", "mutton", "fish", "eggs", "chana dal", "millet", "oats", "peanuts", "sesame seeds"
            ]
        ]
    ],
    "Rajasthan" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Opt for lean meats like chicken and fish prepared with light spices.",
                "Grill or bake meats instead of frying, and avoid heavy gravies.",
                "Use fresh vegetables like spinach, cauliflower, and cabbage in meals.",
                "Use mustard oil or sunflower oil sparingly."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "mustard oil", "spinach", "cauliflower", "cabbage"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use calorie-dense meats like mutton or goat cooked in rich gravies with ghee and butter.",
                "Incorporate eggs and dairy products like paneer and curd for additional protein and fat.",
                "Add traditional North Indian snacks like pakoras, samosas, and rich gravies with rice.",
                "Include rich sweets like laddoos and halwa made with ghee and sugar."
            ],
            "Raw Materials" => [
                "Mutton", "eggs", "paneer", "ghee", "butter", "laddoos", "halwa ingredients"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein meats like chicken, mutton, and fish along with eggs.",
                "Use protein-rich legumes like chana dal and soybeans for added plant-based protein.",
                "Include whole grains like millet and oats for complex carbohydrates.",
                "Add nuts and seeds like peanuts and sesame seeds for additional protein and fats."
            ],
            "Raw Materials" => [
                "Chicken", "mutton", "fish", "eggs", "chana dal", "millet", "oats", "peanuts", "sesame seeds"
            ]
        ]
    ],
    "Arunachal Pradesh" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Opt for lean proteins such as fish (small indigenous species) and chicken prepared with light spices.",
                "Grill or steam meats instead of preparing them in rich gravies or fried dishes.",
                "Use mustard oil sparingly for cooking.",
                "Include fresh vegetables like fiddlehead ferns, bamboo shoots, and leafy greens in meals."
            ],
            "Raw Materials" => [
                "Fish", "chicken", "mustard oil", "fiddlehead ferns", "bamboo shoots", "leafy greens"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use calorie-dense meats like pork, often prepared in rich gravies or smoked, which is common in Northeast Indian cuisine.",
                "Incorporate traditional snacks like pitha and sticky rice dishes, along with boiled eggs and dairy products.",
                "Cook dishes using ghee or butter, and include rich curries and stews with rice.",
                "Incorporate calorie-dense traditional dishes like thukpa and momos with added butter or ghee."
            ],
            "Raw Materials" => [
                "Pork", "sticky rice", "ghee", "butter", "eggs", "pitha", "momos"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein meats like chicken, fish, and pork.",
                "Use eggs and dairy products like paneer for protein-rich meals.",
                "Add protein-rich soybeans, lentils, and legumes for muscle recovery.",
                "Include more complex carbohydrates like millet, brown rice, and sweet potatoes for energy."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "pork", "eggs", "paneer", "soybeans", "millet", "brown rice"
            ]
        ]
    ],
    "Assam" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Opt for lean proteins such as fish (small indigenous species) and chicken prepared with light spices.",
                "Grill or steam meats instead of preparing them in rich gravies or fried dishes.",
                "Use mustard oil sparingly for cooking.",
                "Include fresh vegetables like fiddlehead ferns, bamboo shoots, and leafy greens in meals."
            ],
            "Raw Materials" => [
                "Fish", "chicken", "mustard oil", "fiddlehead ferns", "bamboo shoots", "leafy greens"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use calorie-dense meats like pork, often prepared in rich gravies or smoked, which is common in Northeast Indian cuisine.",
                "Incorporate traditional snacks like pitha and sticky rice dishes, along with boiled eggs and dairy products.",
                "Cook dishes using ghee or butter, and include rich curries and stews with rice.",
                "Incorporate calorie-dense traditional dishes like thukpa and momos with added butter or ghee."
            ],
            "Raw Materials" => [
                "Pork", "sticky rice", "ghee", "butter", "eggs", "pitha", "momos"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein meats like chicken, fish, and pork.",
                "Use eggs and dairy products like paneer for protein-rich meals.",
                "Add protein-rich soybeans, lentils, and legumes for muscle recovery.",
                "Include more complex carbohydrates like millet, brown rice, and sweet potatoes for energy."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "pork", "eggs", "paneer", "soybeans", "millet", "brown rice"
            ]
        ]
    ],
    "Manipur" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Opt for lean proteins such as fish (small indigenous species) and chicken prepared with light spices.",
                "Grill or steam meats instead of preparing them in rich gravies or fried dishes.",
                "Use mustard oil sparingly for cooking.",
                "Include fresh vegetables like fiddlehead ferns, bamboo shoots, and leafy greens in meals."
            ],
            "Raw Materials" => [
                "Fish", "chicken", "mustard oil", "fiddlehead ferns", "bamboo shoots", "leafy greens"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use calorie-dense meats like pork, often prepared in rich gravies or smoked, which is common in Northeast Indian cuisine.",
                "Incorporate traditional snacks like pitha and sticky rice dishes, along with boiled eggs and dairy products.",
                "Cook dishes using ghee or butter, and include rich curries and stews with rice.",
                "Incorporate calorie-dense traditional dishes like thukpa and momos with added butter or ghee."
            ],
            "Raw Materials" => [
                "Pork", "sticky rice", "ghee", "butter", "eggs", "pitha", "momos"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein meats like chicken, fish, and pork.",
                "Use eggs and dairy products like paneer for protein-rich meals.",
                "Add protein-rich soybeans, lentils, and legumes for muscle recovery.",
                "Include more complex carbohydrates like millet, brown rice, and sweet potatoes for energy."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "pork", "eggs", "paneer", "soybeans", "millet", "brown rice"
            ]
        ]
    ],
    "Mizoram" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Opt for lean proteins such as fish (small indigenous species) and chicken prepared with light spices.",
                "Grill or steam meats instead of preparing them in rich gravies or fried dishes.",
                "Use mustard oil sparingly for cooking.",
                "Include fresh vegetables like fiddlehead ferns, bamboo shoots, and leafy greens in meals."
            ],
            "Raw Materials" => [
                "Fish", "chicken", "mustard oil", "fiddlehead ferns", "bamboo shoots", "leafy greens"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use calorie-dense meats like pork, often prepared in rich gravies or smoked, which is common in Northeast Indian cuisine.",
                "Incorporate traditional snacks like pitha and sticky rice dishes, along with boiled eggs and dairy products.",
                "Cook dishes using ghee or butter, and include rich curries and stews with rice.",
                "Incorporate calorie-dense traditional dishes like thukpa and momos with added butter or ghee."
            ],
            "Raw Materials" => [
                "Pork", "sticky rice", "ghee", "butter", "eggs", "pitha", "momos"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein meats like chicken, fish, and pork.",
                "Use eggs and dairy products like paneer for protein-rich meals.",
                "Add protein-rich soybeans, lentils, and legumes for muscle recovery.",
                "Include more complex carbohydrates like millet, brown rice, and sweet potatoes for energy."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "pork", "eggs", "paneer", "soybeans", "millet", "brown rice"
            ]
        ]
    ],
    "Meghalaya" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Opt for lean proteins such as fish (small indigenous species) and chicken prepared with light spices.",
                "Grill or steam meats instead of preparing them in rich gravies or fried dishes.",
                "Use mustard oil sparingly for cooking.",
                "Include fresh vegetables like fiddlehead ferns, bamboo shoots, and leafy greens in meals."
            ],
            "Raw Materials" => [
                "Fish", "chicken", "mustard oil", "fiddlehead ferns", "bamboo shoots", "leafy greens"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use calorie-dense meats like pork, often prepared in rich gravies or smoked, which is common in Northeast Indian cuisine.",
                "Incorporate traditional snacks like pitha and sticky rice dishes, along with boiled eggs and dairy products.",
                "Cook dishes using ghee or butter, and include rich curries and stews with rice.",
                "Incorporate calorie-dense traditional dishes like thukpa and momos with added butter or ghee."
            ],
            "Raw Materials" => [
                "Pork", "sticky rice", "ghee", "butter", "eggs", "pitha", "momos"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein meats like chicken, fish, and pork.",
                "Use eggs and dairy products like paneer for protein-rich meals.",
                "Add protein-rich soybeans, lentils, and legumes for muscle recovery.",
                "Include more complex carbohydrates like millet, brown rice, and sweet potatoes for energy."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "pork", "eggs", "paneer", "soybeans", "millet", "brown rice"
            ]
        ]
    ],
    "Nagaland" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Opt for lean proteins such as fish (small indigenous species) and chicken prepared with light spices.",
                "Grill or steam meats instead of preparing them in rich gravies or fried dishes.",
                "Use mustard oil sparingly for cooking.",
                "Include fresh vegetables like fiddlehead ferns, bamboo shoots, and leafy greens in meals."
            ],
            "Raw Materials" => [
                "Fish", "chicken", "mustard oil", "fiddlehead ferns", "bamboo shoots", "leafy greens"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use calorie-dense meats like pork, often prepared in rich gravies or smoked, which is common in Northeast Indian cuisine.",
                "Incorporate traditional snacks like pitha and sticky rice dishes, along with boiled eggs and dairy products.",
                "Cook dishes using ghee or butter, and include rich curries and stews with rice.",
                "Incorporate calorie-dense traditional dishes like thukpa and momos with added butter or ghee."
            ],
            "Raw Materials" => [
                "Pork", "sticky rice", "ghee", "butter", "eggs", "pitha", "momos"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein meats like chicken, fish, and pork.",
                "Use eggs and dairy products like paneer for protein-rich meals.",
                "Add protein-rich soybeans, lentils, and legumes for muscle recovery.",
                "Include more complex carbohydrates like millet, brown rice, and sweet potatoes for energy."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "pork", "eggs", "paneer", "soybeans", "millet", "brown rice"
            ]
        ]
    ],
    "Sikkim" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Opt for lean proteins such as fish (small indigenous species) and chicken prepared with light spices.",
                "Grill or steam meats instead of preparing them in rich gravies or fried dishes.",
                "Use mustard oil sparingly for cooking.",
                "Include fresh vegetables like fiddlehead ferns, bamboo shoots, and leafy greens in meals."
            ],
            "Raw Materials" => [
                "Fish", "chicken", "mustard oil", "fiddlehead ferns", "bamboo shoots", "leafy greens"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use calorie-dense meats like pork, often prepared in rich gravies or smoked, which is common in Northeast Indian cuisine.",
                "Incorporate traditional snacks like pitha and sticky rice dishes, along with boiled eggs and dairy products.",
                "Cook dishes using ghee or butter, and include rich curries and stews with rice.",
                "Incorporate calorie-dense traditional dishes like thukpa and momos with added butter or ghee."
            ],
            "Raw Materials" => [
                "Pork", "sticky rice", "ghee", "butter", "eggs", "pitha", "momos"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein meats like chicken, fish, and pork.",
                "Use eggs and dairy products like paneer for protein-rich meals.",
                "Add protein-rich soybeans, lentils, and legumes for muscle recovery.",
                "Include more complex carbohydrates like millet, brown rice, and sweet potatoes for energy."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "pork", "eggs", "paneer", "soybeans", "millet", "brown rice"
            ]
        ]
    ],
    "Tripura" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Opt for lean proteins such as fish (small indigenous species) and chicken prepared with light spices.",
                "Grill or steam meats instead of preparing them in rich gravies or fried dishes.",
                "Use mustard oil sparingly for cooking.",
                "Include fresh vegetables like fiddlehead ferns, bamboo shoots, and leafy greens in meals."
            ],
            "Raw Materials" => [
                "Fish", "chicken", "mustard oil", "fiddlehead ferns", "bamboo shoots", "leafy greens"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use calorie-dense meats like pork, often prepared in rich gravies or smoked, which is common in Northeast Indian cuisine.",
                "Incorporate traditional snacks like pitha and sticky rice dishes, along with boiled eggs and dairy products.",
                "Cook dishes using ghee or butter, and include rich curries and stews with rice.",
                "Incorporate calorie-dense traditional dishes like thukpa and momos with added butter or ghee."
            ],
            "Raw Materials" => [
                "Pork", "sticky rice", "ghee", "butter", "eggs", "pitha", "momos"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein meats like chicken, fish, and pork.",
                "Use eggs and dairy products like paneer for protein-rich meals.",
                "Add protein-rich soybeans, lentils, and legumes for muscle recovery.",
                "Include more complex carbohydrates like millet, brown rice, and sweet potatoes for energy."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "pork", "eggs", "paneer", "soybeans", "millet", "brown rice"
            ]
        ]
    ],
    "Andaman & Nicobar Islands" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Opt for lean proteins like chicken and fish, commonly used in South Indian curries and stews.",
                "Grill or steam meats instead of preparing them in rich coconut-based gravies.",
                "Use coconut oil in small quantities and include more fresh vegetables in light curries.",
                "Include more greens like spinach and amaranth in daily meals."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "coconut oil", "spinach", "amaranth"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use calorie-dense meats like mutton or goat in rich coconut-based gravies.",
                "Add eggs and dairy products like paneer and curd in meals for protein and fat.",
                "Incorporate traditional snacks like vadas, idlis, and rich sweets like laddoos and halwa made with jaggery and ghee.",
                "Include seafood like prawns, crab, and squid in rich curries."
            ],
            "Raw Materials" => [
                "Mutton", "eggs", "paneer", "curd", "prawns", "squid", "ghee", "laddoos"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein meats like chicken, mutton, and fish.",
                "Use eggs and dairy products like paneer and curd for muscle recovery.",
                "Add protein-rich legumes like chana dal and toor dal for additional protein.",
                "Incorporate nuts such as almonds and peanuts for extra protein and healthy fats."
            ],
            "Raw Materials" => [
                "Chicken", "mutton", "fish", "eggs", "paneer", "chana dal", "peanuts"
            ]
        ]
    ],
    "Andhra Pradesh" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Opt for lean proteins like chicken and fish, commonly used in South Indian curries and stews.",
                "Grill or steam meats instead of preparing them in rich coconut-based gravies.",
                "Use coconut oil in small quantities and include more fresh vegetables in light curries.",
                "Include more greens like spinach and amaranth in daily meals."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "coconut oil", "spinach", "amaranth"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use calorie-dense meats like mutton or goat in rich coconut-based gravies.",
                "Add eggs and dairy products like paneer and curd in meals for protein and fat.",
                "Incorporate traditional snacks like vadas, idlis, and rich sweets like laddoos and halwa made with jaggery and ghee.",
                "Include seafood like prawns, crab, and squid in rich curries."
            ],
            "Raw Materials" => [
                "Mutton", "eggs", "paneer", "curd", "prawns", "squid", "ghee", "laddoos"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein meats like chicken, mutton, and fish.",
                "Use eggs and dairy products like paneer and curd for muscle recovery.",
                "Add protein-rich legumes like chana dal and toor dal for additional protein.",
                "Incorporate nuts such as almonds and peanuts for extra protein and healthy fats."
            ],
            "Raw Materials" => [
                "Chicken", "mutton", "fish", "eggs", "paneer", "chana dal", "peanuts"
            ]
        ]
    ],
    "Karnataka" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Opt for lean proteins like chicken and fish, commonly used in South Indian curries and stews.",
                "Grill or steam meats instead of preparing them in rich coconut-based gravies.",
                "Use coconut oil in small quantities and include more fresh vegetables in light curries.",
                "Include more greens like spinach and amaranth in daily meals."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "coconut oil", "spinach", "amaranth"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use calorie-dense meats like mutton or goat in rich coconut-based gravies.",
                "Add eggs and dairy products like paneer and curd in meals for protein and fat.",
                "Incorporate traditional snacks like vadas, idlis, and rich sweets like laddoos and halwa made with jaggery and ghee.",
                "Include seafood like prawns, crab, and squid in rich curries."
            ],
            "Raw Materials" => [
                "Mutton", "eggs", "paneer", "curd", "prawns", "squid", "ghee", "laddoos"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein meats like chicken, mutton, and fish.",
                "Use eggs and dairy products like paneer and curd for muscle recovery.",
                "Add protein-rich legumes like chana dal and toor dal for additional protein.",
                "Incorporate nuts such as almonds and peanuts for extra protein and healthy fats."
            ],
            "Raw Materials" => [
                "Chicken", "mutton", "fish", "eggs", "paneer", "chana dal", "peanuts"
            ]
        ]
    ],
    "Kerala" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Opt for lean proteins like chicken and fish, commonly used in South Indian curries and stews.",
                "Grill or steam meats instead of preparing them in rich coconut-based gravies.",
                "Use coconut oil in small quantities and include more fresh vegetables in light curries.",
                "Include more greens like spinach and amaranth in daily meals."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "coconut oil", "spinach", "amaranth"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use calorie-dense meats like mutton or goat in rich coconut-based gravies.",
                "Add eggs and dairy products like paneer and curd in meals for protein and fat.",
                "Incorporate traditional snacks like vadas, idlis, and rich sweets like laddoos and halwa made with jaggery and ghee.",
                "Include seafood like prawns, crab, and squid in rich curries."
            ],
            "Raw Materials" => [
                "Mutton", "eggs", "paneer", "curd", "prawns", "squid", "ghee", "laddoos"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein meats like chicken, mutton, and fish.",
                "Use eggs and dairy products like paneer and curd for muscle recovery.",
                "Add protein-rich legumes like chana dal and toor dal for additional protein.",
                "Incorporate nuts such as almonds and peanuts for extra protein and healthy fats."
            ],
            "Raw Materials" => [
                "Chicken", "mutton", "fish", "eggs", "paneer", "chana dal", "peanuts"
            ]
        ]
    ],
    "Lakshadweep" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Opt for lean proteins like chicken and fish, commonly used in South Indian curries and stews.",
                "Grill or steam meats instead of preparing them in rich coconut-based gravies.",
                "Use coconut oil in small quantities and include more fresh vegetables in light curries.",
                "Include more greens like spinach and amaranth in daily meals."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "coconut oil", "spinach", "amaranth"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use calorie-dense meats like mutton or goat in rich coconut-based gravies.",
                "Add eggs and dairy products like paneer and curd in meals for protein and fat.",
                "Incorporate traditional snacks like vadas, idlis, and rich sweets like laddoos and halwa made with jaggery and ghee.",
                "Include seafood like prawns, crab, and squid in rich curries."
            ],
            "Raw Materials" => [
                "Mutton", "eggs", "paneer", "curd", "prawns", "squid", "ghee", "laddoos"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein meats like chicken, mutton, and fish.",
                "Use eggs and dairy products like paneer and curd for muscle recovery.",
                "Add protein-rich legumes like chana dal and toor dal for additional protein.",
                "Incorporate nuts such as almonds and peanuts for extra protein and healthy fats."
            ],
            "Raw Materials" => [
                "Chicken", "mutton", "fish", "eggs", "paneer", "chana dal", "peanuts"
            ]
        ]
    ],
    "Pondicherry" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Opt for lean proteins like chicken and fish, commonly used in South Indian curries and stews.",
                "Grill or steam meats instead of preparing them in rich coconut-based gravies.",
                "Use coconut oil in small quantities and include more fresh vegetables in light curries.",
                "Include more greens like spinach and amaranth in daily meals."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "coconut oil", "spinach", "amaranth"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use calorie-dense meats like mutton or goat in rich coconut-based gravies.",
                "Add eggs and dairy products like paneer and curd in meals for protein and fat.",
                "Incorporate traditional snacks like vadas, idlis, and rich sweets like laddoos and halwa made with jaggery and ghee.",
                "Include seafood like prawns, crab, and squid in rich curries."
            ],
            "Raw Materials" => [
                "Mutton", "eggs", "paneer", "curd", "prawns", "squid", "ghee", "laddoos"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein meats like chicken, mutton, and fish.",
                "Use eggs and dairy products like paneer and curd for muscle recovery.",
                "Add protein-rich legumes like chana dal and toor dal for additional protein.",
                "Incorporate nuts such as almonds and peanuts for extra protein and healthy fats."
            ],
            "Raw Materials" => [
                "Chicken", "mutton", "fish", "eggs", "paneer", "chana dal", "peanuts"
            ]
        ]
    ],
    "Telangana" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Opt for lean proteins like chicken and fish, commonly used in South Indian curries and stews.",
                "Grill or steam meats instead of preparing them in rich coconut-based gravies.",
                "Use coconut oil in small quantities and include more fresh vegetables in light curries.",
                "Include more greens like spinach and amaranth in daily meals."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "coconut oil", "spinach", "amaranth"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use calorie-dense meats like mutton or goat in rich coconut-based gravies.",
                "Add eggs and dairy products like paneer and curd in meals for protein and fat.",
                "Incorporate traditional snacks like vadas, idlis, and rich sweets like laddoos and halwa made with jaggery and ghee.",
                "Include seafood like prawns, crab, and squid in rich curries."
            ],
            "Raw Materials" => [
                "Mutton", "eggs", "paneer", "curd", "prawns", "squid", "ghee", "laddoos"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein meats like chicken, mutton, and fish.",
                "Use eggs and dairy products like paneer and curd for muscle recovery.",
                "Add protein-rich legumes like chana dal and toor dal for additional protein.",
                "Incorporate nuts such as almonds and peanuts for extra protein and healthy fats."
            ],
            "Raw Materials" => [
                "Chicken", "mutton", "fish", "eggs", "paneer", "chana dal", "peanuts"
            ]
        ]
    ],
    "Tamil Nadu" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Opt for lean proteins like chicken and fish, commonly used in South Indian curries and stews.",
                "Grill or steam meats instead of preparing them in rich coconut-based gravies.",
                "Use coconut oil in small quantities and include more fresh vegetables in light curries.",
                "Include more greens like spinach and amaranth in daily meals."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "coconut oil", "spinach", "amaranth"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use calorie-dense meats like mutton or goat in rich coconut-based gravies.",
                "Add eggs and dairy products like paneer and curd in meals for protein and fat.",
                "Incorporate traditional snacks like vadas, idlis, and rich sweets like laddoos and halwa made with jaggery and ghee.",
                "Include seafood like prawns, crab, and squid in rich curries."
            ],
            "Raw Materials" => [
                "Mutton", "eggs", "paneer", "curd", "prawns", "squid", "ghee", "laddoos"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein meats like chicken, mutton, and fish.",
                "Use eggs and dairy products like paneer and curd for muscle recovery.",
                "Add protein-rich legumes like chana dal and toor dal for additional protein.",
                "Incorporate nuts such as almonds and peanuts for extra protein and healthy fats."
            ],
            "Raw Materials" => [
                "Chicken", "mutton", "fish", "eggs", "paneer", "chana dal", "peanuts"
            ]
        ]
    ],
    "Dadra & Nagar Haveli" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Opt for lean proteins like chicken and fish, often grilled or steamed.",
                "Use groundnut oil or sesame oil sparingly in cooking.",
                "Incorporate local vegetables such as ridge gourd, fenugreek leaves, and bottle gourd.",
                "Replace rich curries with lighter soups and grilled meats for a balanced diet."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "groundnut oil", "fenugreek leaves", "ridge gourd", "bottle gourd"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use calorie-dense meats like mutton or goat cooked in rich gravies.",
                "Incorporate more dairy products like paneer and curd for additional protein and fats.",
                "Include traditional West Indian snacks like samosas, kachoris, and dhoklas, which are high in carbohydrates.",
                "Use more ghee and butter in cooking."
            ],
            "Raw Materials" => [
                "Mutton", "goat", "paneer", "curd", "ghee", "butter", "dhokla", "samosas"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein meats like chicken and mutton along with eggs for muscle recovery.",
                "Use soy products, paneer, and dairy as additional protein sources.",
                "Add complex carbohydrates like jowar, bajra, and quinoa for sustained energy.",
                "Incorporate nuts and seeds like peanuts and sunflower seeds for healthy fats."
            ],
            "Raw Materials" => [
                "Chicken", "mutton", "eggs", "paneer", "soy products", "jowar", "bajra", "peanuts", "sunflower seeds"
            ]
        ]
    ],
    "Diu & Daman" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Opt for lean proteins like chicken and fish, often grilled or steamed.",
                "Use groundnut oil or sesame oil sparingly in cooking.",
                "Incorporate local vegetables such as ridge gourd, fenugreek leaves, and bottle gourd.",
                "Replace rich curries with lighter soups and grilled meats for a balanced diet."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "groundnut oil", "fenugreek leaves", "ridge gourd", "bottle gourd"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use calorie-dense meats like mutton or goat cooked in rich gravies.",
                "Incorporate more dairy products like paneer and curd for additional protein and fats.",
                "Include traditional West Indian snacks like samosas, kachoris, and dhoklas, which are high in carbohydrates.",
                "Use more ghee and butter in cooking."
            ],
            "Raw Materials" => [
                "Mutton", "goat", "paneer", "curd", "ghee", "butter", "dhokla", "samosas"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein meats like chicken and mutton along with eggs for muscle recovery.",
                "Use soy products, paneer, and dairy as additional protein sources.",
                "Add complex carbohydrates like jowar, bajra, and quinoa for sustained energy.",
                "Incorporate nuts and seeds like peanuts and sunflower seeds for healthy fats."
            ],
            "Raw Materials" => [
                "Chicken", "mutton", "eggs", "paneer", "soy products", "jowar", "bajra", "peanuts", "sunflower seeds"
            ]
        ]
    ],
    "Goa" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Opt for lean proteins like chicken and fish, often grilled or steamed.",
                "Use groundnut oil or sesame oil sparingly in cooking.",
                "Incorporate local vegetables such as ridge gourd, fenugreek leaves, and bottle gourd.",
                "Replace rich curries with lighter soups and grilled meats for a balanced diet."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "groundnut oil", "fenugreek leaves", "ridge gourd", "bottle gourd"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use calorie-dense meats like mutton or goat cooked in rich gravies.",
                "Incorporate more dairy products like paneer and curd for additional protein and fats.",
                "Include traditional West Indian snacks like samosas, kachoris, and dhoklas, which are high in carbohydrates.",
                "Use more ghee and butter in cooking."
            ],
            "Raw Materials" => [
                "Mutton", "goat", "paneer", "curd", "ghee", "butter", "dhokla", "samosas"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein meats like chicken and mutton along with eggs for muscle recovery.",
                "Use soy products, paneer, and dairy as additional protein sources.",
                "Add complex carbohydrates like jowar, bajra, and quinoa for sustained energy.",
                "Incorporate nuts and seeds like peanuts and sunflower seeds for healthy fats."
            ],
            "Raw Materials" => [
                "Chicken", "mutton", "eggs", "paneer", "soy products", "jowar", "bajra", "peanuts", "sunflower seeds"
            ]
        ]
    ],
    "Gujarat" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Opt for lean proteins like chicken and fish, often grilled or steamed.",
                "Use groundnut oil or sesame oil sparingly in cooking.",
                "Incorporate local vegetables such as ridge gourd, fenugreek leaves, and bottle gourd.",
                "Replace rich curries with lighter soups and grilled meats for a balanced diet."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "groundnut oil", "fenugreek leaves", "ridge gourd", "bottle gourd"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use calorie-dense meats like mutton or goat cooked in rich gravies.",
                "Incorporate more dairy products like paneer and curd for additional protein and fats.",
                "Include traditional West Indian snacks like samosas, kachoris, and dhoklas, which are high in carbohydrates.",
                "Use more ghee and butter in cooking."
            ],
            "Raw Materials" => [
                "Mutton", "goat", "paneer", "curd", "ghee", "butter", "dhokla", "samosas"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein meats like chicken and mutton along with eggs for muscle recovery.",
                "Use soy products, paneer, and dairy as additional protein sources.",
                "Add complex carbohydrates like jowar, bajra, and quinoa for sustained energy.",
                "Incorporate nuts and seeds like peanuts and sunflower seeds for healthy fats."
            ],
            "Raw Materials" => [
                "Chicken", "mutton", "eggs", "paneer", "soy products", "jowar", "bajra", "peanuts", "sunflower seeds"
            ]
        ]
    ],
    "Maharashtra" => [
        "Weight Loss" => [
            "Dietary Changes" => [
                "Opt for lean proteins like chicken and fish, often grilled or steamed.",
                "Use groundnut oil or sesame oil sparingly in cooking.",
                "Incorporate local vegetables such as ridge gourd, fenugreek leaves, and bottle gourd.",
                "Replace rich curries with lighter soups and grilled meats for a balanced diet."
            ],
            "Raw Materials" => [
                "Chicken", "fish", "groundnut oil", "fenugreek leaves", "ridge gourd", "bottle gourd"
            ]
        ],
        "Weight Gain" => [
            "Dietary Changes" => [
                "Use calorie-dense meats like mutton or goat cooked in rich gravies.",
                "Incorporate more dairy products like paneer and curd for additional protein and fats.",
                "Include traditional West Indian snacks like samosas, kachoris, and dhoklas, which are high in carbohydrates.",
                "Use more ghee and butter in cooking."
            ],
            "Raw Materials" => [
                "Mutton", "goat", "paneer", "curd", "ghee", "butter", "dhokla", "samosas"
            ]
        ],
        "Muscle Gain" => [
            "Dietary Changes" => [
                "Focus on high-protein meats like chicken and mutton along with eggs for muscle recovery.",
                "Use soy products, paneer, and dairy as additional protein sources.",
                "Add complex carbohydrates like jowar, bajra, and quinoa for sustained energy.",
                "Incorporate nuts and seeds like peanuts and sunflower seeds for healthy fats."
            ],
            "Raw Materials" => [
                "Chicken", "mutton", "eggs", "paneer", "soy products", "jowar", "bajra", "peanuts", "sunflower seeds"
            ]
        ]
    ],
];

$state = $_SESSION['state'];
$diet_plan = $diet_plans[$state] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mixed Diet Plan — Fitness Fusion</title>
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
    <h1>🍗 Mixed Diet Plan</h1>
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
