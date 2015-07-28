$( document ).ready(function() {

    $("#select_options input[name='optradio']").change(function () {

        var team_picked = $('input:radio[name=optradio]:checked').val();

        $('input[type=radio][value=team_picked]').prop('checked',true);

        $.post( "/app/ajax/team_selection.php", { user_id: user_id, current_week: current_week, team_picked: team_picked},
            function(data){
                $("#message span").text(data);
            } );

    });

});