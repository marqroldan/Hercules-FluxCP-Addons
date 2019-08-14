<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Character Generator</h2>
<?php if (count($name_array)==0): ?>
<h3 style="margin-bottom: 352px;">You currently have no characters.</h3>
<?php else: ?>
<script type='text/javascript'>
	<?php
	$js_array = json_encode($name_array);
	echo "var jnames = ". $js_array . ";\n";
	?>

	g = "";
	function updateCharDetails(id) {
		g	= 
					"&name="+jnames[id].name
					+"&class="+jnames[id].class
		            +"&clothes_color="+jnames[id].clothes_color
		            +"&hair="+jnames[id].hair
		            +"&hair_color="+jnames[id].hair_color
		            +"&head_top="+jnames[id].head_top
		            +"&head_mid="+jnames[id].head_mid
		            +"&head_bottom="+jnames[id].head_bottom
		            +"&robe="+jnames[id].robe
		            +"&weapon="+jnames[id].weapon
		            +"&shield="+jnames[id].shield
		            +"&online="+jnames[id].online
		            +"&base_level="+jnames[id].base_level
		            +"&job_level="+jnames[id].job_level
		            +"&sex="+jnames[id].sex
		            +"&emblem_data="+jnames[id].emblem_data
		;
		return g;
	}
	function updateAvaDet(){
		g = updateCharDetails(document.getElementById("usernames").value);
		direction = document.getElementById("direction").value;
		background = document.getElementById("background").value;
		border = document.getElementById("border").value;
		action_ = document.getElementById("action_").value;
		doridori = document.getElementById("doridori").value;
		body_animation = document.getElementById("body_animation").value;
		if (document.getElementById('no_border').checked) {
			g+="&no_border=true";
		}
		else {
			g+="&no_border=false";
		}
		if(direction!="") g+="&direction="+direction;
		if(background!="") g+="&background="+background;
		if(action_!="") g+="&action_="+action_;
		if(doridori!="") g+="&doridori="+doridori;
		if(body_animation!="") g+="&body_animation="+body_animation;
		if(border!="") g+="&border="+border;
		
		document.getElementById("name").value = jnames[document.getElementById("usernames").value].name;
		document.getElementById("charpre").src="<?php echo $this->url('chargen','avatar') ?>"+g+"&preview=true";
	}
	function updateSigDet(){
		g = updateCharDetails(document.getElementById("usernames_sig").value);
		direction = document.getElementById("direction_sig").value;
		background = document.getElementById("background_sig").value;
		action = document.getElementById("action_sig").value;
		doridori = document.getElementById("doridori_sig").value;
		animation = document.getElementById("animation_sig").value;
		
		if(direction!="") g+="&direction="+direction;
		if(background!="") g+="&background="+background;
		if(action!="") g+="&action_="+action;
		if(doridori!="") g+="&doridori="+doridori;
		if(animation!="") g+="&body_animation="+animation;
		
		document.getElementById("char_nam_sig").value = jnames[document.getElementById("usernames_sig").value].name;
		document.getElementById("charpre_sig").src="<?php echo $this->url('chargen','signature') ?>&preview=true"+g;
	}
</script>
<?php if($params->get("saved")): ?>
<div class="alert alert-primary alert-dismissible fade show" role="alert">
	Successfully saved. <a href="<?php echo $this->url('chargen',$params->get('save_type'), array('request'=>$params->get('save_name'))) ?>" target="_blank">View it here.</a>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">×</span>
  </button>
</div>
<?php else: ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
	Either an error has occurred or the generated image wasn't saved. Please try again.
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">×</span>
  </button>
</div>
<?php endif ?>

<!-- Character Avatar -->
<h3>Avatar Creation</h3>
<form id="ch_ava" action="<?php echo $this->url('chargen', 'avatar') ?>" method="post" >
		
		<!-- Character Details -->
		<input type="hidden" value="" id="name" name="name"/>
		
		<table class="t_charg">
		  <tr>
			<td rowspan="4" style="width: 128px; height: 128px;">
				<div class="chargen_preview" style="height: 128px; height: 128px; text-align: center; line-height: 128px; vertical-align: middle;">
					<img id="charpre" name="charpre" class="charpre" src="" />
				</div>
			</td>
			<td>Characters: 
					<select id="usernames" name="usernames" onchange="updateAvaDet()">
						<option selected disabled hidden value=''></option>
						<?php 
						foreach ($name_array as $id_ => $data) {
							echo "<option value='".$id_."'>".$data['name']."</option>";					
						}?>
					</select>
			</td>
			<td>Direction:
					<select id="direction" name="direction" onchange="updateAvaDet()">
						<option selected disabled hidden value=''></option>
						<option value="0">South</option>
						<option value="1">Southwest</option>
						<option value="2">West</option>
						<option value="3">Northwest</option>
						<option value="4">North</option>
						<option value="5">Northeast</option>
						<option value="6">East</option>
						<option value="7">Southeast</option>
					</select>
			</td>
		  </tr>
		  <tr>
			<td>Background:
					<select id="background" name="background" onchange="updateAvaDet()">
						<option selected disabled hidden value=''></option>
						<?php foreach ($avaBGList as $img) {
							echo "<option value='".$img."'>".str_replace(".", "", str_replace($supported_file, "",$img))."</option>";					
						}?>
					</select>
			</td>
			<td>Action:
					<select id="action_" name="action_" onchange="updateAvaDet()">
						<option selected disabled hidden value=''></option>
						<option value="ACTION_IDLE">Idle</option>
						<option value="ACTION_WALK">Walk</option>
						<option value="ACTION_SIT">Sit </option>
						<option value="ACTION_PICKUP">Pick up</option>
						<option value="ACTION_READYFIGHT">Ready, fight! </option>
						<option value="ACTION_ATTACK">Attack</option>
						<option value="ACTION_HURT">Hurt</option>
						<option value="ACTION_UNK1">Hit 1</option>
						<option value="ACTION_UNK2">Hit 2</option>
						<option value="ACTION_DIE">Die </option>
						<option value="ACTION_SKILL">Skill</option>
						<option value="ACTION_ATTACK2">Attack 2</option>
						<option value="ACTION_ATTACK3">Attack 3</option>
					</select>
			
			</td>
		  </tr>
		  <tr>
			<td>Body Animation:
					<select id="body_animation" name="body_animation" onchange="updateAvaDet()">
						<option selected disabled hidden value=''></option>
						<?php for($i = 0; $i<21; $i++)
							echo "<option value='".$i."'>".$i."</option>";
						?>
					</select>
			</td>
			<td>Doridori:
					<select id="doridori" name="doridori" onchange="updateAvaDet()">
						<option selected disabled hidden value=''></option>
						<option value="0">Front</option>
						<option value="1">Left</option>
						<option value="2">Right</option>
					</select>
			
			</td>
		  </tr>
		  <tr>
			<td>Border:
					<select id="border" name="border" onchange="updateAvaDet()">
						<option selected disabled hidden value=''></option>
						<?php foreach ($avaBDList as $img) {
							echo "<option value='".$img."'>".str_replace(".", "", str_replace($supported_file, "",$img))."</option>";					
						}?>
					</select>
			</td>
			<td>
				<input type="checkbox" name="no_border" id="no_border" value="true" checked onclick="updateAvaDet()">Disable borders?
			</td>
			<td align="right">
				<input  type="submit" value="Save"/>
			</td>
		  </tr>
		</table> 
		
</form>

<br>

<!-- Character Signature -->
<h3>Create your signature here</h3>
<form id="ch_ava" action="<?php echo $this->url('chargen', 'signature') ?>" method="post" >
		
		<!-- Character Details -->
		<input type="hidden" value="" id="char_nam_sig" name="name"/>
		
		
		<table class="t_charg">
		  <tr>
			<td rowspan="4" style="width: 194px; height: 110px;">
				<div class="chargen_preview" style="width: 194px; height: 110px;">
					<img id="charpre_sig" name="charpre_sig" class="charpre" src="" />
				</div>
			</td>
			<td>Characters: 
					<select id="usernames_sig" name="usernames" onchange="updateSigDet()">
						<option selected disabled hidden value=''></option>
						<?php 
						
						foreach ($name_array as $id_ => $data) {
							echo "<option value='".$id_."'>".$data['name']."</option>";					
						}?>
					</select>
			</td>
			<td>Direction:
					<select id="direction_sig" name="direction" onchange="updateSigDet()">
						<option selected disabled hidden value=''></option>
						<option value="0">South</option>
						<option value="1">Southwest</option>
						<option value="2">West</option>
						<option value="3">Northwest</option>
						<option value="4">North</option>
						<option value="5">Northeast</option>
						<option value="6">East</option>
						<option value="7">Southeast</option>
					</select>
			</td>
		  </tr>
		  <tr>
			<td>Background:
					<select id="background_sig" name="background" onchange="updateSigDet()">
						<option selected disabled hidden value=''></option>
						<?php foreach ($sigBGList as $img) {
							echo "<option value='".$img."'>".$img."</option>";					
						}?>
					</select>
			</td>
			<td>Action:
					<select id="action_sig" name="action_" onchange="updateSigDet()">
						<option selected disabled hidden value=''></option>
						<option value="ACTION_IDLE">Idle</option>
						<option value="ACTION_WALK">Walk</option>
						<option value="ACTION_SIT">Sit </option>
						<option value="ACTION_PICKUP">Pick up</option>
						<option value="ACTION_READYFIGHT">Ready, fight! </option>
						<option value="ACTION_ATTACK">Attack</option>
						<option value="ACTION_HURT">Hurt</option>
						<option value="ACTION_UNK1">Hit 1</option>
						<option value="ACTION_UNK2">Hit 2</option>
						<option value="ACTION_DIE">Die </option>
						<option value="ACTION_SKILL">Skill</option>
						<option value="ACTION_ATTACK2">Attack 2</option>
						<option value="ACTION_ATTACK3">Attack 3</option>
					</select>
			
			</td>
		  </tr>
		  <tr>
			<td>Body Animation:
					<select id="animation_sig" name="body_animation" onchange="updateSigDet()">
						<option selected disabled hidden value=''></option>
						<?php for($i = 0; $i<21; $i++)
							echo "<option value='".$i."'>".$i."</option>";
						?>
					</select>
			</td>
			<td>Doridori:
					<select id="doridori_sig" name="doridori" onchange="updateSigDet()">
						<option selected disabled hidden value=''></option>
						<option value="0">Front</option>
						<option value="1">Left</option>
						<option value="2">Right</option>
					</select>
			
			</td>
		  </tr>
		  <tr>
			<td colspan="2" align="right">
				<input  type="submit" value="Save"/>
			</td>
		  </tr>
		</table> 
		
</form>
<?php endif ?>