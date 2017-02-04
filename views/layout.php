<DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/css/materialize.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    </head>
    <body>
        <nav class="brown darken-3" role="navigation">
            <div class="nav-wrapper container">
                <span class="brand-logo">Robot Simulator</span>
            </div>
        </nav>
        <div class="container">
        <?php require_once('routes.php'); ?>
        </div>
    <body>
    
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/js/materialize.min.js"></script>

    <script type="text/javascript">
    $('.voteBtn').click(function(){
        var thisPositionIdentifier = '.position_' + $(this).attr('position'); // create selector
        var hiddenInput = $(thisPositionIdentifier); //get hidden input

        //no action if user has already voted for the current position
        if (hiddenInput.val() == '') {
            hiddenInput.val($(this).attr('id')); //set value of that input
            var thisButtonIdentifier = '.btn_' + $(this).attr('position');
            
            //change color of vote button of other candidates of the same position
            $(thisButtonIdentifier).not(this).each(function(){
                $(this).addClass('disabled');
            });
        }
    });
</script>

<html>