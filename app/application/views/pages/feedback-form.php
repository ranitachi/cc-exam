<?php 
// echo form_open(site_url('pages/finishfeedback'), array('id' => 'exam-form')); 
?>
<form action="<?=site_url()?>pages/finishfeedback/sc" id="exam-form" onSubmit="return cek()" method="post">
	
	
	<div class="left-pane" style="width:100%">

		  <div class="tabs" style="margin-top:0px !important;width:100% !important">
 
   <!-- Radio button and lable for #tab-content1 -->
		   <input type="radio" name="tabs" id="tab1" checked >
		   <label for="tab1">
		       <i class="fa fa-html5"></i><span>Evaluasi Pembelajaran</span>
		   </label>
		 
		   <!-- Radio button and lable for #tab-content2 -->
		  
		   <input type="radio" name="tabs" id="tab2">
		   <label for="tab2">
		       <i class="fa fa-css3"></i><span>Evaluasi Keseluruhan</span>
		   </label>
		 		 
		   <div id="tab-content1" class="tab-content">
		   	<div>
		    	<div style="width:20%;float:left;text-align:right;padding-right:10px;">No Registrasi</div>  
		    	<div style="width:75%;float:left;text-align:left;font-weight:bold">:&nbsp;&nbsp;
		    		<input type="text" onkeyup="cekfeedback(this.value)" id="noregis" style="width:200px;padding:5px;">
		    		<div id="tes"></div>
		    	</div>  
		   	</div>

		   	<div id="form1">
		   		
		   	
			   	<div>
			    	<div style="width:20%;float:left;text-align:right;padding-right:10px;">Jurusan</div>  
			    	<div style="width:75%;float:left;text-align:left;font-weight:bold">:&nbsp;&nbsp;
			    		<span id="jurusan"></span>
			    		<input type="hidden" name="batch_id" id="batch_id" >
						<input type="hidden" name="batch_code" id="batch_code" >
						<input type="hidden" name="faculty_id" id="faculty_id" >
						<input type="hidden" name="faculty_code" id="faculty_code" >
						<input type="hidden" name="module_code" id="module_code" >
						<input type="hidden" name="student_code" id="student_code" >
			    		<!-- <select name="jurusan"></select> -->
			    	</div>  
			   	</div>
			   	<div>
			    	<div style="width:20%;float:left;text-align:right;padding-right:10px;">Mata Kuliah</div>  
			    	<div style="width:75%;float:left;text-align:left;font-weight:bold">:&nbsp;&nbsp;
			    	<span id="matakuliah"></span>
			    	</div>  
			   	</div>		   	
			   	<div>
			    	<div style="width:20%;float:left;text-align:right;padding-right:10px;">Nama Faculty</div>  
			    	<div style="width:75%;float:left;text-align:left;font-weight:bold">:&nbsp;&nbsp;
			    		<span id="facultyname"></span>
			    	</div>  
			   	</div>
			   	<div>
			    	<div style="width:20%;float:left;text-align:right;padding-right:10px;">Kelas</div>  
			    	<div style="width:75%;float:left;text-align:left;font-weight:bold">:&nbsp;&nbsp;
			    	<span id="kelas"></span>
			    	</div>  
			   	</div>
			    <h3 style="float:left;margin-top:20px;width:100%">Petunjuk Pengisian :</h3>
			    <h5  style="font-size:12px;padding-top:10px;float:left;width:100%">
			    Pilihlah jawaban yang Saudara anggap paling sesuai pada  kolom di sebelah kanan yang tersedia.
			    <br>
			    Sesuai dengan yang Saudara ketahui, berilah penilaian secara jujur, objektif, dan penuh tanggung Jawab.
			    <br>
			    Informasi yang Saudara berikan akan dipergunakan sebagai bahan masukan bagi Faculty.
			    <br>
			    Pilihlah jawaban yang paling sesuai  menurut Saudara.
			    </h5>
			    <div style="width:100%;float:left;margin-top:20px;">
			    	<?
			    	$data['d']=$feed['khusus'];
			    	?>
			    	<?=$this->load->view('pages/feedback-table',$data)?>
			    </div>
			   </div>
		   </div> <!-- #tab-content1 -->
		  
		   <div id="tab-content2" class="tab-content">
		   	<div id="form2">
			      <div>
			    	<div style="width:20%;float:left;text-align:right;padding-right:10px;">Jurusan</div>  
				    	<div style="width:75%;float:left;text-align:left;font-weight:bold">:&nbsp;&nbsp;
				    	<span id="jurusan2"></span>
				    		
				    	</div>  
				   	</div>
				   	<div>
				    	<div style="width:20%;float:left;text-align:right;padding-right:10px;">Kelas</div>  
				    	<div style="width:75%;float:left;text-align:left;font-weight:bold">:&nbsp;&nbsp;
				    	<span id="kelas2"></span>
				    	</div>  
				   	</div>
				  <h3 style="float:left;margin-top:20px;width:100%">Petunjuk Pengisian :</h3>
			    <h5  style="font-size:12px;padding-top:10px;float:left;width:100%">
			    Pilihlah jawaban yang Saudara anggap paling sesuai pada  kolom di sebelah kanan yang tersedia.
			    <br>
			    Sesuai dengan yang Saudara ketahui, berilah penilaian secara jujur, objektif, dan penuh tanggung Jawab.
			    <br>
			    Informasi yang Saudara berikan akan dipergunakan sebagai bahan masukan bagi Faculty.
			    <br>
			    Pilihlah jawaban yang paling sesuai  menurut Saudara.
			    </h5>
			     <div style="width:100%;float:left;margin-top:20px;">
			    	<?
			    		$dt['d']=$feed['umum'];
			    	?>
			    	<?=$this->load->view('pages/feedback-table',$dt)?>
			    </div>
		    </div>
		   </div> <!-- #tab-content2 -->
		  <h1 id="pesan" style="text-align:center;font-size:30px;"></h1>
        <div style="width:100%;text-align:center;" id="form-button">
        	<input type="submit" value="Simpan" class="button">
        </div>
		</div>


	</div>

<?php echo form_close(); ?>

<div class="expander"></div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#noregis').focus();
	});
	function cek()
	{
		var c=confirm('Apakah Yakin Sudah Mengisi Form Feedback Dengan Benar ?');
		if(c)
		{
			return true;
		}
		else
			return false;
			
		return false;
	}

	function cekfeedback(v)
	{
		$.ajax({
			url : '<?=site_url()?>pages/cekfeedback',
			type : 'POST',
			data : {no : v},
			success : function(a)
			{
				var o=a.split('|');
				if(o[0]==0)
				{
					$('#form-button').hide();
					$('#form1').hide();
					$('#form2').hide();
					$('#pesan').html(o[1]);
				}
				else
				{
					$('#form-button').show();
					$('#form1').show();
					$('#form2').show();
					$('#pesan').text('');
					$('#jurusan').text(o[3]);
					$('#jurusan2').text(o[3]);
					$('#kelas').text(o[8]);
					$('#kelas2').text(o[8]);
					$('#facultyname').text(o[6]);
					$('#matakuliah').text(o[2]);
					//student_codemodule_codefaculty_codefaculty_idbatch_idbatch_code
					$('#student_code').val(o[1]);
					$('#module_code').val(o[2]);
					$('#faculty_code').val(o[4]);
					$('#faculty_id').val(o[5]);
					$('#batch_id').val(o[7]);
					$('#batch_code').val(o[8]);
				}
				// alert(a);
				// $('#tes').text(a);
			}
		});
	}
</script>

<style type="text/css">
	.tabs {
    max-width: 100%;
    float: none;
    list-style: none;
    padding: 0;
    margin: 15px auto;
    border-bottom: 2px solid #ccc;
}
 
.tabs:after {
    content: '';
    display: table;
    clear: both;
}
 
.tabs input[type=radio] {
    display:none;
}
 
.tabs label {
    display: block;
    float: left;
    width: 50%;
 
    color: #ccc;
    font-size: 30px;
    font-weight: normal;
    text-decoration: none;
    text-align: center;
    line-height: 2;
 
    cursor: pointer;
    box-shadow: inset 0 4px #ccc;
    border-bottom: 4px solid #ccc;
 
    -webkit-transition: all 0.5s; /* Safari 3.1 to 6.0 */
    transition: all 0.5s;
}
  
.tabs label span {
    display: none;
}
 
.tabs label i {
    padding: 5px;
    margin-right: 0;
}
 
.tabs label:hover {
    color: #3498db;
    box-shadow: inset 0 4px #3498db;
    border-bottom: 4px solid #3498db;
}
 
.tab-content {
    display: none;
    width: 100%;
    float: left;
    padding: 15px;
    box-sizing: border-box;
  
    background-color:#ffffff;
}

.tab-content * {
 
    -webkit-animation: scale 0.7s ease-in-out;
    -moz-animation: scale 0.7s ease-in-out;
    animation: scale 0.7s ease-in-out;
}
 
/*@keyframes scale {
 
  0% { 
    transform: scale(0.9);
    opacity: 0;
    }
 
  50% {
    transform: scale(1.01);
    opacity: 0.5;
    }
 
  100% { 
    transform: scale(1);
    opacity: 1;
  }
 
}*/
.tabs [id^="tab"]:checked + label {
    background: #ddd;
    box-shadow: inset 0 4px #3498db;
    border-bottom: 4px solid #3498db;
    color: #3498db;
}
 
#tab1:checked ~ #tab-content1,
#tab2:checked ~ #tab-content2,
#tab3:checked ~ #tab-content3 {
    display: block;
}
@media (min-width: 1024px) {   
    .tabs i {
        padding: 5px;
        margin-right: 10px;
    }
 
    .tabs label span {
        display: inline-block;
    }
 
    .tabs {
   max-width: 100%;
   margin: 50px auto;
    }
}
</style>