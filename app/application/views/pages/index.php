<div class="front-image">
	<img src="/static/engineering-center.jpg" alt="" />
</div>

<div class="left-pane">
	<h1>Sekilas CCIT-FTUI</h1>
	<p>CCIT-FTUI merupakan salah satu unit pendidikan yang didirikan oleh Fakultas Teknik Universitas Indonesia sejak 2002. Di CCIT-FTUI kamu akan dididik menjadi seorang professional di bidang IT (Information Technology) dengan kurikulum internasional kerjasama dengan NIIT, yaitu salah satu institusi pendidikan IT dengan jaringan di lebih dari 40 negara di dunia. Kurikulum yang digunakan pada TA 2010/2011 diberi nama kurikulum MasterMind Series (MMS) Versi 2 yang merupakan pengembangan dari sebelumnya. Dimana kalian akan diberikan fleksibilitas untuk memilih jalur peminatan Software Engineering atau Network Engineering dengan metode pembelajaran LACC (Learning Architecture based on Collaborative Contructivism) yang terdiri dari pemberian materi oleh pengajar dilanjutkan dengan interaksi atar siswa melalui diskusi dan pengembangan pola pikir berdasarkan konsepsi materi dan siswa diwajibkan praktek untuk menerapkan materi tersebut.</p>
</div>

<div class="right-pane">

	<h1>Exam Student Login</h1>

	<?php if (!empty($error)) : ?>
		<p class="error">Your registration code and/or ticket is incorrect!</p>
	<?php endif; ?>

	<?php echo form_open(site_url('pages/login')); ?>

		<div class="input">
			<label for="code">Registration Code</label>
			<input type="text" name="code" id="code" class="small" />
		</div>

		<div class="input">
			<label for="ticket">Exam Ticket</label>
			<input type="password" name="ticket" id="ticket" class="small" />
		</div>

		<input type="submit" value="Login" />

	<?php echo form_close(); ?>

</div>

<div class="expander"></div>
