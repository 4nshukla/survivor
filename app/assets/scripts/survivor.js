$( document ).ready(function() {

    $("#select_options input[name='optradio']").click(function () {

        var team_picked = $('input:radio[name=optradio]:checked').val();
        $.post( "/app/ajax/team_selection.php", { user_id: user_id, current_week: current_week, team_picked: team_picked} );
        alert(user_id + current_week + team_picked);
    });

});