<?php
session_start();

$analysisResults = '';
$inputText = '';
$errorMessage = '';
$urlContent = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['text_input'])) {
        $inputText = trim($_POST['text_input']);
        $analysisResults = performAnalysis($inputText);
    } elseif (isset($_POST['url_input'])) {
        $url = filter_var($_POST['url_input'], FILTER_VALIDATE_URL);
        if ($url !== false) {
            // Using cURL 
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); 

            $urlContent = curl_exec($ch);
            if (curl_errno($ch)) {
                $errorMessage = "Error fetching URL: " . curl_error($ch);
            } else {
                $inputText = strip_tags($urlContent);
                $analysisResults = performAnalysis($inputText);
            }
            curl_close($ch);
        } else {
            $errorMessage = "Invalid URL provided.";
        }
    }
}

function performAnalysis($text) {
    $wordCount = str_word_count($text);
    $sentenceCount = preg_match_all('/[.!?]/', $text, $matches);
    // Most common words
    $words = str_word_count(strtolower($text), 1);
    $wordsFrequency = array_count_values($words);
    arsort($wordsFrequency);
    
    $analysis = "Word Count: $wordCount\n";
    $analysis .= "Sentence Count: $sentenceCount\n";
    $analysis .= "Most Common Words:\n";
    foreach ($wordsFrequency as $word => $freq) {
        $analysis .= "$word: $freq\n";
    }

    return nl2br(htmlspecialchars($analysis));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Text Analysis</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f9; }
        .title { font-size: 28px; text-align: center; margin-top: 20px; background-image: linear-gradient(to right, red, orange, yellow, green, blue, indigo, violet); color: transparent; -webkit-background-clip: text; }
        .instructions { background: beige; padding: 10px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin: 10px auto; font-size: 16px; text-align: center; max-width: 800px; }
        .container { max-width: 800px; margin: auto; padding: 10px; }
        textarea, input[type="text"] { width: 100%; padding: 8px; margin-bottom: 10px; }
        .button { padding: 8px 16px; margin: 10px; font-size: 18px; cursor: pointer; }
        .error-message { color: red; }
        .analysis-results { background: #fff; border: 1px solid #ddd; padding: 10px; }
        /*.color-change { color: #009688; } */
        .color-change-1 { color: #e53935; } /* red */
        .color-change-2 { color: #d81b60; } /* pink */
        .color-change-3 { color: #8e24aa; } /* purple */
        .color-change-4 { color: #5e35b1; } /* deep purple */
        .color-change-5 { color: #3949ab; } /* indigo */
        .color-change-6 { color: #1e88e5; } /* blue */
        .color-change-7 { color: #039be5; } /* light blue */
        .color-change-8 { color: #00acc1; } /* cyan */
        .color-change-9 { color: #00897b; } /* teal */
        .color-change-10 { color: #43a047; }
        .back-to-main-button {
    position: fixed; /* Fixed position */
    top: 10px; /* 10px from the top */
    right: 10px; /* 10px from the right */
    background-color: #FF3B30; /* Red background */
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    z-index: 1000; /* Make sure it's above other items */
}

.back-to-main-button:hover {
    background-color: #4CAF50; /* Green background on hover */
}



    </style>
</head>
<body>
    <h1 class="title">Text Analysis Tool</h1>
    <div class="instructions">
        <p>You can paste your article to get analysis.</p>
        <p>You can search for keywords, refresh content, change text color, and see the most popular words.</p>
    </div>
    <button class="back-to-main-button" onclick="window.location.href='index.php';">Back to Main Page</button>

    <div class="container">
        <form action="script6.php" method="post">
            <textarea name="text_input" rows="6" placeholder="Enter your text here..."><?= $inputText ?></textarea>
            <!--<input type="text" name="url_input" placeholder="Or enter a URL to fetch content...">  -->
            <div class="buttons-container">
                <button type="submit" class="button">Analyze</button>
                <button type="button" onclick="location.reload();" class="button">Refresh</button>
                <button type="button" onclick="changeTextColor();" class="button">Change Color</button>
            </div>     </form>

        <div class="error-message"><?= $errorMessage ?></div>

        <div class="analysis-results">
            <h3>Analysis Results:</h3>
            <?= $analysisResults ?>
        </div>
    </div>


    <!--
    <div class="container">
        <button onclick="location.reload();" class="button">Refresh</button>
        <button onclick="changeTextColor();" class="button">Change Color</button>
    </div>
-->
<script>
var currentColorIndex = 0;
var colorClasses = [
    'color-change-1', 'color-change-2', 'color-change-3',
    'color-change-4', 'color-change-5', 'color-change-6',
    'color-change-7', 'color-change-8', 'color-change-9',
    'color-change-10'
];

function changeTextColor() {
    var resultsDiv = document.querySelector('.analysis-results');
    // Remove the previous color class if it exists
    if (currentColorIndex > 0) {
        resultsDiv.classList.remove(colorClasses[currentColorIndex - 1]);
    }
    // Add the new color class
    resultsDiv.classList.add(colorClasses[currentColorIndex]);
    
    // Increment the color index
    currentColorIndex = (currentColorIndex + 1) % colorClasses.length;
}
</script>
</body>
</html>
