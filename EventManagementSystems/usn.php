<!DOCTYPE html>
<html>
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Event Status MSU</title>
        <link rel='icon' href='images/logo.png' type='image/x-icon'/ >
        <?php require 'utils/styles.php'; ?><!--css links. file found in utils folder-->
    </head>
    <body>
        <?php require 'utils/header.php'; ?><!--header content. file found in utils folder-->

        <div class ="content"><!--body content holder-->
            <div class = "container">
                <div class ="col-xs-12 col-sm-12 col-md-6 col-md-offset-3">
                    <form action="RegisteredEvents.php" class ="form-group" method="POST">

                        
                        <div class="form-group">
                            <label for="usn"> Student USN/ID: </label>
                            <input type="text"
                                   id="usn"
                                   name="usn"
                                   class="form-control">
                        </div>
                        <button type="submit" class = "btn btn-default">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
