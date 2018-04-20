<?
if($sc=='')
{
?>
<div class="left-pane">

	<h1><?php echo $exam_name; ?></h1>


		<p>
		<h1>Terima Kasih Sudah Mengisi Form Feedback</h1>	
		<a href="<?php echo site_url('pages/exam'); ?>" class="button">Start the Exam</a></p>
		<script type="text/javascript">
			set_cookie('remaining_time', <?php echo $remaining_time; ?>, 30, '/', '', '');
		</script>
		

</div>

<div class="right-pane">

	<h1>Welcome!</h1>

	<p>Please verify your identity below. If there is any mistake, please report it to the exam committee immediately.</p>

	<h2>Registration Code :</h2>
	<p><?php echo $code; ?></p>

	<h2>Student Name :</h2>
	<p><?php echo $name; ?></p>

</div>
<?
}
else
{
?>
<div class="left-pane" style="width:100%;text-align:center">

	<h1><?php echo $exam_name; ?></h1>


		<p>
		<h1 style="border-bottom:0px;">Terima Kasih Sudah Mengisi Form Feedback</h1>	
		<h1>Silahkan Tutup Halaman Ini</h1>	
		<!-- <a href="javascript:self.close()" class="button">Klik Disini Untuk Memulai QT</a></p> -->
</div>
<?
}
?>
<div class="expander"></div>
