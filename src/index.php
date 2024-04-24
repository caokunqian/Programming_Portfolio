<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jack Qian's Portfolio</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('1.jpg');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
        }
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9); /* semi-transparent white */
            border-radius: 10px;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        a {
            color: #1e88e5; /* blue */
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .title {
            background-image: linear-gradient(to right, red, orange, yellow, green, blue, indigo, violet);
            color: transparent;
            -webkit-background-clip: text;
            font-size: 2.5em;
            text-align: center;
            margin: 20px 0;
        }
        .description {
            color: white; /* white text */
            margin-bottom: 10px;
        }
        .block {
            background-color: #e0e0e0;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .block a { /* Link colors within blocks */
            color: #1e88e5; /* blue */
            font-weight: bold;
        }
        .block .description {
            color: black; /* Overriding the white text for descriptions within blocks */
        }
        .blue-block { /*it is black now */
            background-color: #000; /* black */
            color: white; /* white text */
        }
        .link-list { 
            list-style-type: none; 
            padding-left: 0; /* Remove padding */
        }
        .link-list li { 
            margin-bottom: 10px; 
            font-size: 1em; /* Enlarged font size */
        }
        .link { 
            background-color: Red; 
            padding: 10px; /* Increased padding */
            border-radius: 8px; 
            display: inline-block; 
            margin-right: 5px; 
            transition: background-color 0.3s; /* Smooth transition for hover effect */
        }
        .link:hover { 
            background-color: Green; 
        }
    </style>
</head>
<body>
    <!-- Portfolio Information Block -->
    <div class="container block">
        <div class="title">Jack Qian's Final Portfolio</div>
        <p class="description">
            Author: Jack Qian<br>
            Instructor: Dr. Ronald Loui<br>
            <a href="https://github.com/caokunqian/Programming_Portfolio">Link to GitHub</a><br>
            <a href="https://github.com/caokunqian/Programming_Portfolio/commits/main/">Version Control</a>
        </p>
    </div>

    <!-- Links to Scripts Block -->
    <div class="container block blue-block">
        <ul class="link-list">
            <li>
        <span class="link">script1.php</span>
                Network and Server Health Monitor - A tool to view details of the network interface and server health.
            </li>
            <li>
                <span class="link">script2.php</span>
                2048 Game - A web-based version of the popular slide puzzle game.
            </li>
            <li>
                <span class="link">script3.php</span>
                Memory Game - A simple card matching game to test and improve your memory.
            </li>
            <li>
                <span class="link">script4.php</span>
                Poll Maker - An interactive polling tool with real-time result updates.
            </li>
            <li>
                <span class="link">script5.php</span>
                To-Do List - Manage your tasks effectively with a dynamic to-do list.
            </li>
            <li>
                <span class="link">script6.php</span>
                Text Analysis Tool - Analyze text for the most common words, word count, and sentence count.
            </li>
        </ul>
    </div>
    <script>
        // Add event listeners to the links to navigate to the scripts
        document.querySelectorAll('.link').forEach(link => {
            link.addEventListener('click', function() {
                var scriptName = this.textContent;
                window.location.href = scriptName;
            });
        });
    </script>
</body>
</html>
