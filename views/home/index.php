<form action="?controller=home&action=submit" method="post">
	<br>
	<label for="grid_parameters">Grid Size</label>
	<input type="text" name="grid_parameters">
	<label for="robot1_settings">Robot 1 Settings (x-coordinate, y-coordinate, direction[N,E,W,S])</label>
	<input type="text" name="robot1_settings">
	<label for="robot1_commands">Robot 1 Command (M-move, R-turn right, L-turn left)</label>
	<input type="text" name="robot1_commands">
	<label for="robot2_settings">Robot 2 Settings (x-coordinate, y-coordinate, direction[N,E,W,S])</label>
	<input type="text" name="robot2_settings">
	<label for="robot2_commands">Robot 2 Command (M-move, R-turn right, L-turn left)</label>
	<input type="text" name="robot2_commands">

	<button class="btn waves-effect waves-light btn-large deep-orange s4" type="submit">Submit
	<i class="material-icons right">send</i>
	</button>

</form>

