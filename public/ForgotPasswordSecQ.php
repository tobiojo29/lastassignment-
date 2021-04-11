<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../resources/secure_app.css">
    <meta charset="utf-8" />
    <title>Secure App - Forgot Password</title>
</head>

<body>
    <div id="wrapper">
        <header>
            <table class="header_table">
                <tbody>
                <tr>
                    <td class="lock"><img src="../resources/Header_Lock_Image.svg" style="width:9vh;" alt="Header_lock"></td>
                    <td class="title"><b>Secure App</b></td>
                    <td class="header_table_cell"></td>
                </tr>
                </tbody>
            </table>
        </header>

        <main>
        <br>
            <!--Heading-->
            <h1>Forgot Password</h1>
            <div class=horizontal_line>
                <hr>
            </div>

            <p>Who is your Favorite Relative?</p>
            <div class = "SecurityQuestion">
                <?php
                                $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                   if("answercheck=fail" == parse_url($url, PHP_URL_QUERY))
                            {
                            echo "The answer is invalid";
                            }

                ?>

                <div id="SecQ">
                </div>

                <form action="../src/ForgotPasswordSecQLogic.php" method="POST">
                    <label for="Answer">Answer:&nbsp;&nbsp;</label>
                    <input type="text" id="Answer" name="Answer"><br><br>
                    <input type="submit" value="Submit">
                </form>
            </div>
        </main>
    </div>
</body>
</html>