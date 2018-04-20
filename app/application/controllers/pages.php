<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends APP_Controller {

	public function index($error = null) {

		$data['error'] = $error;
		$this->load->view('index',$data);
		// $this->render('index', $data);
	}

	public function ccexam($error = null) {

		$data['error'] = $error;
		$this->render('pages/index', $data);
	}		

	public function formfeedback($error = null) {

		$data['error'] = $error;
		$data['title'] = 'Form Feedback';
		// $this->load->view('index',$data);
		$fb=$this->db->query('select * from quisioner where status="t" order by jenis desc,category,id;');
		$feed=array();
		foreach ($fb->result() as $k => $v) 
		{
			$feed[$v->jenis][$v->category][]=$v;
		}
		$data['feed']=$feed;
		$this->render('pages/feedback-form', $data);
	}	

	function cekfeedback()
	{
		$no=$_POST['no'];
		$cekstudentbatch = $this->db->query('select * from batch_student_view where student_code="'.$no.'" and batch_active=1');
		// echo $no;
		if(strlen($no)>=10)
		{
			if($cekstudentbatch->num_rows!=0)
			{

				/*$cek=$this->db->query('select * from quisioner_data as qd 
									inner join quisioner as q on (q.id=qd.quisioner_id) 
									inner join batch as b on (qd.batch_id=b.id) 
									where qd.student_code="'.$no.'" and b.active=1');

				if($cek->num_rows!=0)
				{
					echo '0|<span style="color:blue;font-size:30px;">Terima Kasih..<br>Anda Sudah Pernah Mengisi Form Feedback Untuk Semester Ini</span>';
				}
				else
				{*/
					//student_codemodule_codefaculty_codefaculty_idbatch_idbatch_code
					$cekb=$this->db->query('select * from batch_view where id='.$cekstudentbatch->row('batch_id').'');
					$batch_module=$this->db->query('select * from batch_schedule_view where batch_id='.$cekstudentbatch->row('batch_id').' order by id desc');
					$x='1|';
					$x.=$cekstudentbatch->row('student_code').'|';
					$x.=$batch_module->row('module_code').'|';
					$x.=$batch_module->row('module_name').'|';
					$x.=$batch_module->row('faculty_code').'|';
					$x.=$batch_module->row('faculty_id').'|';
					$x.=$batch_module->row('faculty_name').'|';
					$x.=$cekb->row('id').'|';
					$x.=$cekb->row('code');
					echo $x;
				//}

			}
			else
			{
				echo '0|Maaf, Nomor Registrasi Anda Tidak Ditemukan';
			}
		}
		else
			echo '1||||||||';

	}

	public function login() {

		$code = $this->input->post('code');
		$ticket = $this->input->post('ticket');
		//$this->db->select('s.id as student_id,s.code AS "student_code", s.name AS "student_name", es.id AS "id", es.remaining_time AS "remaining_time", eb.name AS "exam_name", eb.exam_id AS "exam_id"')->from('exam_student es')->join('batch_exam_ore_view eb', 'eb.id = es.batch_exam_id')->join('batch_student bs', 'bs.id = es.batch_student_id')->join('student s', 's.id = bs.student_id')->where('s.code', $code)->where('es.ticket', $ticket)->where('es.active', 1);
		//$exam_student = $this->db->get()->first_row('array');
		$exam_student=$this->db->query("SELECT 
				`s`.`id` as student_id, 
				`s`.`code` AS student_code, 
				`s`.`name` AS student_name, 
				`es`.`id` AS id, 
				`es`.`remaining_time` AS remaining_time, 
				`es`.`batch_student_id` AS batch_student_id,
				`eb`.`name` AS exam_name, 
				`eb`.`exam_id` AS exam_id,
				eb.ore
			FROM 
				(`exam_student` es) 
				JOIN `batch_exam` eb ON `eb`.`id` = `es`.`batch_exam_id` 
				JOIN `batch_student` bs ON `bs`.`id` = `es`.`batch_student_id` 
				JOIN `student` s ON `s`.`id` = `bs`.`student_id` 
				
			WHERE 
				`s`.`code` = '".$code."' AND 
				`es`.`ticket` = '".$ticket."' AND 
				`es`.`active` = 1

			union

			SELECT 
				os.student_id, 
				os.student_code, 
				os.student_name, 
				os.id, 
				os.remaining_time, 
				os.batch_student_id,
				os.name_ore, 
				`eb`.`exam_id`,
				'1'
			from ore_student_view as os
			inner join ore_view as eb on (eb.id=os.ore_id)
			 
			WHERE 
				`os`.`student_code` = '".$code."' AND 
				`os`.`ticket` = '".$ticket."' AND 
				`os`.`active` = 1");

		if ($exam_student->num_rows!=0) {

			$this->session->set_userdata('student_id', $exam_student->row('student_id'));
			$this->session->set_userdata('batch_student_id', $exam_student->row('batch_student_id'));
			$this->session->set_userdata('id', $exam_student->row('id'));
			$this->session->set_userdata('exam_name', $exam_student->row('exam_name'));
			$this->session->set_userdata('exam_id', $exam_student->row('exam_id'));
			$this->session->set_userdata('code', $exam_student->row('student_code'));
			$this->session->set_userdata('name', $exam_student->row('student_name'));
			$this->session->set_userdata('remaining_time', $exam_student->row('remaining_time'));
			$this->session->set_userdata('ore', $exam_student->row('ore'));

			redirect('pages/announcement');

		} else {

			$this->index(1);

		}

	}

	public function announcement() {

		$data['exam_name'] = $this->session->userdata('exam_name');
		$data['exam_id'] = $this->session->userdata('exam_id');
		$data['code'] = $this->session->userdata('code');
		$data['name'] = $this->session->userdata('name');
		$data['remaining_time'] = $this->session->userdata('remaining_time');
		// $data['remaining_time'] = $this->session->userdata('remaining_time');
		$data['ore'] = $this->session->userdata('ore');
		$data['batch_student_id'] = $this->session->userdata('batch_student_id');
		
		if($data['ore']!=1)
		{
			$d=$this->db->query('select * from batch_student_view where id="'.$data['batch_student_id'].'"');
			$ei=$this->db->query('select * from exam_view where id="'.$data['exam_id'].'"');
			// $ei=
			$data['bs']=$d->result();
			$data['ei']=$ei->result();
		}
		else
		{
			$data['bs']=$data['ei']=array();
		}
		$this->render('pages/announcement', $data);

	}

	public function announcementafter($sc='') {

		$data['exam_name'] = $this->session->userdata('exam_name');
		$data['exam_id'] = $this->session->userdata('exam_id');
		$data['code'] = $this->session->userdata('code');
		$data['name'] = $this->session->userdata('name');
		$data['remaining_time'] = $this->session->userdata('remaining_time');
		// $data['remaining_time'] = $this->session->userdata('remaining_time');
		$data['ore'] = $this->session->userdata('ore');
		$data['batch_student_id'] = $this->session->userdata('batch_student_id');
		
		if($data['ore']!=1)
		{
			$d=$this->db->query('select * from batch_student_view where id="'.$data['batch_student_id'].'"');
			$ei=$this->db->query('select * from exam_view where id="'.$data['exam_id'].'"');
			// $ei=
			$data['bs']=$d->result();
			$data['ei']=$ei->result();
		}
		else
		{
			$data['bs']=$data['ei']=array();
		}

		$data['sc']=$sc;

		$this->render('pages/announcementafter', $data);

	}

	public function feedback($error = null) {

		$data['exam_name'] = $this->session->userdata('exam_name');
		$data['exam_id'] = $this->session->userdata('exam_id');
		$data['code'] = $this->session->userdata('code');
		$data['name'] = $this->session->userdata('name');
		$data['remaining_time'] = $this->session->userdata('remaining_time');
		// $data['remaining_time'] = $this->session->userdata('remaining_time');
		$data['ore'] = $this->session->userdata('ore');
		$data['batch_student_id'] = $this->session->userdata('batch_student_id');
		
		if($data['ore']!=1)
		{
			$d=$this->db->query('select * from batch_student_view where id="'.$data['batch_student_id'].'"');
			$ei=$this->db->query('select * from exam_view where id="'.$data['exam_id'].'"');
			$batch=$this->db->query('select * from batch_view where id="'.$d->row('batch_id').'"');

			$mk=strtok($ei->row('code'),'/');
			$matkul=substr($mk, -3,3);
			$sc=$this->db->query('select * from batch_schedule_view where batch_id="'.$d->row('batch_id').'" and module_code like "%'.$matkul.'%" group by faculty_code');
			// $ei=
			$data['batch']=$batch->result();
			$data['bs']=$d->result();
			$data['ei']=$ei->result();
			$data['sc']=$sc->result();

			$cekfeed=$this->db->query('select * from quisioner_data where student_code="'.$data['code'].'" and batch_id="'.$d->row('batch_id').'"');
			$data['cekfeed']=$cekfeed->result();
		}
		else
		{
			$data['bs']=$data['ei']=$data['sc']=$data['batch']=$data['cekfeed']=array();
		}

		$fb=$this->db->query('select * from quisioner where status="t" order by jenis desc,category,id;');
		$feed=array();
		foreach ($fb->result() as $k => $v) 
		{
			$feed[$v->jenis][$v->category][]=$v;
		}
		$data['feed']=$feed;

		$this->render('pages/feedback', $data);
	}

	function finishfeedback($sc='')
	{
		if(!empty($_POST))
		{
			foreach ($_POST as $k => $v) 
			{
				$d[$k]=$v;
			}

			// $dt['']
			foreach ($d['pilihan'] as $kd => $vd) 
			{
				$d['quisioner_id']=$kd;
				$d['answer']=$vd;
				$d['sugestion']='';
				$this->simpanfeedback($d);			
			}

			foreach ($d['saran'] as $ks => $vs) 
			{
				$d['quisioner_id']=$ks;
				$d['answer']='';
				$d['sugestion']=$vs;
				$this->simpanfeedback($d);			
			}


			redirect('pages/announcementafter/'.$sc,'location');
		}
	}

	function simpanfeedback($data)
	{
		$in=array(
			'student_code'=>$data['student_code'],
			'batch_id'=>$data['batch_id'],
			'batch_code'=>$data['batch_code'],
			'quisioner_id'=>$data['quisioner_id'],
			'answer'=>$data['answer'],
			'sugestion'=>$data['sugestion'],
			'faculty_code'=>$data['faculty_code'],
			'faculty_id'=>$data['faculty_id'],
			'module_code'=>$data['module_code']
		);
		$this->db->insert('quisioner_data',$in);
		// echo  '<pre>';
		// print_r($data);
		// echo  '</pre>';
	}

	public function exam() {

		$data['exam_name'] = $this->session->userdata('exam_name');
		$data['code'] = $this->session->userdata('code');
		$data['name'] = $this->session->userdata('name');
		$data['remaining_time'] = $this->session->userdata('remaining_time');

		$data['exam_set'] = $this->generate_exam_set($this->session->userdata('id'));
		$data['answer_log'] = $this->get_answer_log($this->session->userdata('id'));

		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->render('pages/exam', $data);

	}

	public function finish($xx=null) 
	{

		$total=1;
		$exam_student_id = $this->session->userdata('id');
		$exam_id = $this->session->userdata('exam_id');

		if($this->session->userdata('ore')==1)
		{
			$this->db->select_sum('score')->from('exam_set')->where('ore_student_id', $exam_student_id);
			$score = $this->db->get()->first_row()->score;
		}
		else
		{
			$this->db->select_sum('score')->from('exam_set')->where('exam_student_id', $exam_student_id);
			$score = $this->db->get()->first_row()->score;
		}
		$this->db->select('total_score')->from('exam')->where('id', $exam_id);
		$total = $this->db->get()->first_row()->total_score;

		$this->db->select('time')->from('exam')->where('id', $exam_id);
		$time = $this->db->get()->first_row()->time;

		if ($score / $total * 100 >= 50) { $pass = 1; } else { $pass = 0; }
		
		if($this->session->userdata('ore')==1)
		{
			$this->db->update('ore_student', array('score' => $score, 'pass' => $pass, 'active' => 0), array('id' => $exam_student_id));
		}
		else
		{
			$this->db->update('exam_student', array('score' => $score, 'pass' => $pass, 'active' => 0), array('id' => $exam_student_id));
		}
		$data['exam_name'] = $this->session->userdata('exam_name');
		$data['code'] = $this->session->userdata('code');
		$data['exam_id'] = $exam_id;
		$data['name'] = $this->session->userdata('name');
		$data['score'] = number_format($score / $total * 100,2).'%';
		$data['pass'] = $pass;
		$data['time'] = $time;
		$data['total'] = $total;
		
		if($pass==0)
			$this->session->sess_destroy();

		if($xx!=null)
		{
			$data['xx']=$xx;
			$this->session->sess_destroy();
		}

		$this->render('pages/finish', $data);

	}

	public function answer() {

		$exam_student_id = $this->session->userdata('id');
		$remaining_time = $this->input->post('time');
		// $answer_id = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5("hurrdurr"), base64_decode($this->input->post('id')), MCRYPT_MODE_CBC, md5(md5("hurrdurr"))), "\0");
		$answer_id = $this->input->post('id');

		$this->db->select('question_id, correct')->from('answer')->where('id', $answer_id);
		$answer = $this->db->get()->first_row('array');

		if ($answer['correct']) {
			$this->db->select('weight')->from('question')->where('id', $answer['question_id']);
			$score = $this->db->get()->first_row()->weight;
		} else {
			$score = 0;
		}

		
		
		if($this->session->userdata('ore')==1)
		{
			$this->db->update('exam_set', array('answer_id' => $answer_id, 'score' => $score), array('ore_student_id' => $exam_student_id, 'question_id' => $answer['question_id']));
			$this->db->update('ore_student', array('remaining_time' => $remaining_time), array('id' => $exam_student_id));
		}
		else
		{
			$this->db->update('exam_set', array('answer_id' => $answer_id, 'score' => $score), array('exam_student_id' => $exam_student_id, 'question_id' => $answer['question_id']));
			$this->db->update('exam_student', array('remaining_time' => $remaining_time), array('id' => $exam_student_id));
		}
	}

	function generate_exam_set($exam_student_id) {

		if($this->session->userdata('ore')==1)
			$this->db->select('question_id')->from('exam_set')->where('ore_student_id', $exam_student_id);
		else	
			$this->db->select('question_id')->from('exam_set')->where('exam_student_id', $exam_student_id);
		$questions = $this->db->get()->result_array();
		//$questions=$this->db->query('select question_id from exam_set where exam_student_id="'.$exam_student_id.'"');
		$exam_set = array();
		$st_exam_set='';
		foreach ($questions as $question) 
		{

			$this->db->select('*')->from('question')->where('id', $question['question_id']);
			$exam_set[$question['question_id']]['question'] = $this->db->get()->first_row('array');

			$this->db->select('*')->from('answer')->where('question_id', $question['question_id']);
			$answers = $this->db->get()->result_array();
			shuffle($answers);
			$exam_set[$question['question_id']]['answers'] = $answers;
		}
		$st_exam_set=json_encode($exam_set);
		file_put_contents('../media/text.txt',$st_exam_set);
		// echo '<pre>';
		// print_r($exam_set);
		// echo '</pre>';
		return $exam_set;
	}

	function get_answer_log($exam_student_id) 
	{
		if($this->session->userdata('ore')==1)
			$this->db->select('question_id, answer_id')->from('exam_set')->where('ore_student_id', $exam_student_id);
		else	
			$this->db->select('question_id, answer_id')->from('exam_set')->where('exam_student_id', $exam_student_id);
			
		$questions = $this->db->get()->result_array();

		$answer_log = array();

		foreach ($questions as $question) {
			$answer_log[$question['question_id']] = $question['answer_id'];
		}

		return $answer_log;
	}

	function preprint($s, $return=false) 
	{
        $x = "<pre>";
        $x .= print_r($s, 1);
        $x .= "</pre>";
        if ($return) return $x;
        else print $x;
    }
    
    function pdf($ore,$exam_id,$batch_student_id)
	{
		$e=$this->db->query('select * from exam where id="'.$exam_id.'"');
		$pass_score=$e->row('passing_score');
		$total_score=$e->row('total_score');
		if($ore==0)
		{
			$exam=$this->db->query('select * from exam_student_view where exam_id="'.$exam_id.'" and batch_student_id="'.$batch_student_id.'"');
			$exam_name=$this->db->query('select * from batch_exam_view where id="'.$exam->row('batch_exam_id').'"');
			$en=$exam_name->row('name');
			$student_name=$exam->row('student_name');
			$student_code=$exam->row('student_code');
			$datetime=$exam_name->row('date').' : '.$exam_name->row('time');
			$score=$exam->row('score');
			$pass=$exam->row('pass');
		}
		else if($ore==1)
		{
			$exam=$this->db->query('select * from ore_student_view where exam_id="'.$exam_id.'" and batch_student_id="'.$batch_student_id.'"');
			$ore_name=$this->db->query('select * from ore_view where id="'.$exam->row('ore_id').'"');
			$en=$ore_name->row('name_ore');
			$student_name=$exam->row('student_name');
			$student_code=$exam->row('student_code');
			$datetime=$ore_name->row('date').' : '.$ore_name->row('time');
			$score=$exam->row('score');
			$pass=$exam->row('pass');
		}
		
		$summary = '<style>
				li { left: -10px; }
			</style>
			<table cellspacing="0" cellpadding="1" border="0">
				<tr>
					<td width="20%"><b>Name</b></td>
					<td width="2%"><b>:</b></td>
					<td width="28%"><b>'.$student_name.'</b></td>
				</tr>
				<tr>
					<td width="20%"><b>Date</b></td>
					<td width="2%"><b>:</b></td>
					<td width="28%"><b>'.$datetime.'</b></td>
				</tr>
				<tr>
					<td><b>Registration No.</b></td>
					<td><b>:</b></td>
					<td><b>'.$student_code.'</b></td>
				</tr>
				<tr>
					<td><b>Exam Name</b></td>
					<td><b>:</b></td>
					<td><b>'.$en.'</b></td>
				</tr>
			</table>';

		$isi='
			<style>
				.tbl tr td
				{
					padding-top:10px !important;
					padding-bottom:10px  !important;
					padding-lef:10px !important;
				}
				div.required {
					background-color: blue;
					border-style: solid solid solid solid;
					border-width: 1px 1px 1px 1px;
					text-align:right;
					color:white
				}
				div.passscore {
					background-color: green;
					border-style: solid solid solid solid;
					border-width: 1px 1px 1px 1px;
					text-align:right;
					color:white
				}
				div.failscore {
					background-color: red;
					border-style: solid solid solid solid;
					border-width: 1px 1px 1px 1px;
					text-align:right;
					color:white
				}
				</style>
				';
			
		$ps=($pass_score/100) * 80;	
		if($ps > 40)
		{
			$tblrecuired='<td width="40%">
						<div class="required"></div>  
					</td>
					<td width="'.($ps-40).'%">
						<div class="required">'.$pass_score.' %</div>
					</td>';
		}	
		else
		{
			$tblrecuired='<td width="'.($ps).'%">
						<div class="required">'.$pass_score.' %</div>  
					</td>
					<td width="0%">
						&nbsp;  
					</td>';			
		}
		
		$sc=($score/$total_score) * 80;	
		if($sc > 40)
		{
			$tblpass='<td width="40%">
						<div class="passscore"></div>  
					</td>
					<td width="'.($sc-40).'%">
						<div class="passscore">'.(($score/$total_score)*100).' %</div>
					</td>';
		}	
		else
		{

			$tblpass='<td width="'.($sc<5 ? 5 : $sc).'%">
						<div class="failscore">'.(($score/$total_score)*100).'%</div> 
					</td>
					<td width="'.(80-$sc).'%">
						&nbsp;  
					</td>';			
		}
			
		$isi.='<table cellpadding="0" cellspacing="0" style="border:1px solid #000;" class="tbl">
				<tr><td colspan="2">&nbsp;</td></tr>
				<tr>
					<td width="18%" align="center">Required Score</td>
					'.$tblrecuired.'
				</tr>
				<tr>
					<td width="100%" COLSPAN="2">&nbsp;</td>
				</tr>
				<tr>
					<td width="18%"  align="center">Your Score</td>
					'.$tblpass.'
				</tr>
				<tr>
					<td width="18%"  align="left">&nbsp;</td>
					<td width="26%" align="left" valign="top">
						0%
					</td>
					<td width="27%" align="center"  valign="top">
						50%  
					</td>
					<td width="28%" align="right"  valign="top">
						100%  
					</td>
				</tr>
			</table>
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td width="30%"  align="left">Passing Score : '.$pass_score.' %</td>
					<td width="35%" align="center" valign="top">
						Your Score : '.(($score/$total_score)*100).' %
					</td>
					<td width="35%" align="right"  valign="top">
						Result : '.($pass==1 ? 'PASS' : 'FAIL').'  
					</td>
				</tr>
			</table>
		';
		
		$this->load->helper('pdf_helper');
		tcpdf();
		
		
		
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, "UTF-8", false);

	// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor("CCIT Information System");
		$pdf->SetTitle("Exam Report");
		//$pdf->SetSubject("$performance_report->student_code - $performance_report->student_name");

		//set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		//set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, 0);

		//set some language-dependent strings
		//$pdf->setLanguageArray($GLOBALS["l"]);

		// ---------------------------------------------------------

		// add a page
		$pdf->AddPage();

		$pdf->SetFont("helveticaB");
		$pdf->SetFontSize(10);
		$pdf->Cell(135, 0, "Continuing Education Program - Center for Computing and Information Technology", 0, 0, "R");
		$pdf->Ln();
		$pdf->SetFontSize(14);
		$pdf->Cell(135, 0, "Fakultas Teknik Universitas Indonesia", 0, 0, "R");

		$pdf->Image($_SERVER["DOCUMENT_ROOT"] . "/ccis/static/img/logo.jpg", 160, 10, 40);

		$pdf->Ln(25);
		$pdf->SetFont("helveticaB");
		$pdf->SetFontSize(20);
		$pdf->Cell(0, 0, "EXAM REPORT", 0, 0, "C");
		$pdf->Ln();
		$pdf->SetFont("helvetica");
		$pdf->SetFontSize(10);
		//$pdf->Cell(0, 0, "Ref. No : " . $performance_report->code, 0, 0, "C");
		//$pdf->Cell(0, 0, "Ref. No : 68/H2.F4CCIT/PDP.01.03.Daftar Nilai Semester/2014", 0, 0, "C");

		$pdf->Ln(10);
		$pdf->writeHTML($summary);

		$pdf->Ln(10);
		$pdf->writeHTML($isi);

		
		$pdf->Ln();
		$pdf->SetFontSize(8);
		$pdf->Cell(0, 0, "Generated electronically by CCIT Information System on ".date('d')."/".date('n')."/".date('Y')."", 0, 0, "L");
		$pdf->Cell(0, 0, "----------end of exam report----------", 0, 0, "R");

		

		$pdf->Image($_SERVER["DOCUMENT_ROOT"] . "/ccis/static/img/bg.jpg", 0, 261, 213);

		// ---------------------------------------------------------

		//Close and output PDF document
		$pdf->Output("$student_code-$student_name", "D");
		
		/*$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "PDF Report";
		$obj_pdf->SetTitle($title);
		$obj_pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title, PDF_HEADER_STRING);
		$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$obj_pdf->SetFont('helvetica', '', 9);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();
		ob_start();
			// we can have any view part here like HTML, PHP etc
		$content = ob_get_contents();
		ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output('outputtes.pdf', 'I');*/
	}
}
