<div class="left-pane">

	<h1><?php echo $exam_name; ?></h1>

	<div class="result">
		<h1>
			<?php echo $pass ? '<span style="color:blue;font-size:30px;">PASS</span>' : '<span style="color:red;font-size:30px;">FAIL</span>'; ?>
		</h1>
		<h2 style="padding-bottom:10px;">Score : <?php echo $score; ?> <span class="button" onclick="downloadd('<?php echo $this->session->userdata('ore');?>','<?php echo $exam_id;?>','<?php echo $this->session->userdata('batch_student_id');?>')">Download Result</span> </h2>
	
		<?php 
			if($pass==0)
			{
				if($this->session->userdata('ore')==0)
				{
					$idore=$tgl=$room='';
					$exam_ore=$this->db->query('select * from ore_view where active=1 and exam_id="'.$exam_id.'" order by exam_id,date,time');
					if($exam_ore->num_rows!=0)
					{
						foreach($exam_ore->result() as $eo)
						{
							$cek=$this->db->query('select count(*) as jlh from ore_student_view where ore_id="'.$eo->id.'"');
							if($cek->row('jlh')>=0 && $cek->row('jlh')<=23)
							{
								/*echo 'ore id : '.$eo->id.'<br>';
								echo 'student id : '. $this->session->userdata('student_id').'<br>';
								echo 'time : '. $time.'<br>';*/
								$idore=$eo->id;
								$tgl=$eo->date;
								$waktu=$eo->time;
								$room=$eo->code_room;
								
								$addore=array(
									'ore_id'=>$idore,
									'student_id'=>$this->session->userdata('student_id'),
									'remaining_time'=>$time,
									'active'=>0,
									'batch_student_id'=>$this->session->userdata('batch_student_id')
								);
								$this->db->insert('ore_student',$addore);
								
								break;
							}	
						}
					
					//echo '<br>'.$exam_id.'-'.$idore;
					echo '<h2>Silahkan Mengikuti ORE Pada :<br>';
					echo '<div style="width:400px;float:left">
						<div style="width:150px;float:left">Tanggal</div>
						<div style="width:10px;float:left">:</div>
						<div style="width:240px;float:left">'.$tgl.'</div>
						
						<div style="width:150px;float:left">Waktu</div>
						<div style="width:10px;float:left">:</div>
						<div style="width:240px;float:left">'.$waktu.'</div>
						
						<div style="width:150px;float:left">Ruangan</div>
						<div style="width:10px;float:left">:</div>
						<div style="width:240px;float:left">'.$room.'</div>
					</div></h2>';
					}
				}
			}
			else
			{
				if(!isset($xx))
				{
					if($this->session->userdata('ore')!=1)
					{
		?>
			<h2 style="padding-bottom:20px;" id="info">
				<div style="font-size:15px;font-weight:bold">Apakah anda ingin mengikuti ORE ??</div>
				<br>
				<span class="button" onclick="konfirmasi()">Ya</span>
				<span class="button" onclick="tidak()">Tidak</span>
				<br>
			</h2>
		<?
					}
				}
				else
				{
					if($xx=='ya')
					{
						$idore=$tgl=$room='';
						$exam_ore=$this->db->query('select * from ore_view where active=1 and exam_id="'.$exam_id.'"');
						if($exam_ore->num_rows!=0)
						{
							foreach($exam_ore->result() as $eo)
							{
								$cek=$this->db->query('select count(*) as jlh from ore_student_view where ore_id="'.$eo->id.'"');
								if($cek->row('jlh')>=0 && $cek->row('jlh')<=22)
								{
									/*echo 'ore id : '.$eo->id.'<br>';
									echo 'student id : '. $this->session->userdata('student_id').'<br>';
									echo 'time : '. $time.'<br>';*/
									$idore=$eo->id;
									$tgl=$eo->date;
									$waktu=$eo->time;
									$room=$eo->code_room;
									
									$addore=array(
										'ore_id'=>$idore,
										'student_id'=>$this->session->userdata('student_id'),
										'remaining_time'=>$time,
										'active'=>0,
										'batch_student_id'=>$this->session->userdata('batch_student_id')
									);
									$this->db->insert('ore_student',$addore);
									
									break;
								}	
							}
						
						//echo '<br>'.$exam_id.'-'.$idore;
						echo '<h2>Silahkan Mengikuti ORE Pada :<br>';
						echo '<div style="width:400px;float:left">
							<div style="width:150px;float:left">Tanggal</div>
							<div style="width:10px;float:left">:</div>
							<div style="width:240px;float:left">'.$tgl.'</div>
							
							<div style="width:150px;float:left">Waktu</div>
							<div style="width:10px;float:left">:</div>
							<div style="width:240px;float:left">'.$waktu.'</div>
							
							<div style="width:150px;float:left">Ruangan</div>
							<div style="width:10px;float:left">:</div>
							<div style="width:240px;float:left">'.$room.'</div>
						</div></h2>';
						}
					}
				}
			}
			//echo site_url();
		?>
	</div>

</div>

<div class="right-pane">

	<p>Please verify your identity below. If there is any mistake, please report it to the exam committee immediately.</p>

	<h2>Registration Code :</h2>
	<p><?php echo $code; ?></p>

	<h2>Student Name :</h2>
	<p><?php echo $name; ?></p>

</div>

<div class="expander"></div>
<script>
	function tidak()
	{
		//$('#info').hide();
		location.href='<?=site_url()?>pages/finish/tidak';
	}
	function downloadd(ore,exam_id,batch_student_id)
	{
		//$('#info').hide();
		location.href='<?=site_url()?>pages/pdf/'+ore+'/'+exam_id+'/'+batch_student_id;
		//alert(ore+'/'+exam_id+'/'+batch_student_id);
	}
	function konfirmasi()
	{
		var x=confirm('Apakah Benar-benar Yakin ??');
		if(x)
		{
			location.href='<?=site_url()?>pages/finish/ya';
		}
	}
</script>
