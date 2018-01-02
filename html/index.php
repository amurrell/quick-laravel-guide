<!DOCTYPE html>
<html>
    <head>
	<title>Almost there...</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:300" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Ubuntu+Condensed" rel="stylesheet" type="text/css">
	<link href="style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="main">
            <h1>Great Job! Your project is running!</h1>

            <p>
                You need to
                
                <?php if (!file_exists(__DIR__ . '/../app')) : ?>
                create a <strong>Laravel App</strong> and then
                <?php endif; ?>
                
                change your web server [<strong>nginx</strong>] conf to point to <code>app/public/</code>
            </p>
        </div>
    </body>
</html>
