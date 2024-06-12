<!-- BSG head -->
<!-- BSG menu -->

<!-- $(function(){	alert('jQuery Ready!'); }); -->

<script  type="text/javascript">
	
	function requestsignup() {
	
		var csrfName = $('.txt_csrfname').attr('name');
		var csrfHash = $('.txt_csrfname').val();
		//alert(document.getElementById("c_id").value );

		$.ajax({
				url: "<?=base_url('signupchk')?>",
				method: 'post',
				type:'post',
				data: { 'cid' : document.getElementById("c_id").value , [csrfName]: csrfHash },
				dataType : 'json',
				success : function(res){
					if (res.cnt > 0) {
						alert("기존에 아이디가 있습니다. 다른 아이디를 사용해 주세요.");
						document.getElementById("c_id").focus();
					}else{
						alert("사용가능한 아이디입니다. 계속 진행해 주세요.");
						document.getElementById("c_pw").focus();
					}
					$('.txt_csrfname').val(res.token);
				},
				error: function(xhr, status, error){
					console.log(xhr.status + ', '+xhr.responseText +', '+status+', '+error);
					alert(status);
				}
			});
	}

</script>

<h2> <!--?= esc($title); ?--> </h2>

<?= session()->getFlashdata('error') ?>
<?= service('validation')->listErrors() ?>

				<!-- Main -->
                <article id="main">
						<header>
							<h2>회원가입</h2>
							<p>효율적인 고객관리 그 어딘가로 출발</p>
						</header>
						<section class="wrapper style5">
							<div class="inner">

								<h3>SIGN UP</h3>
								<p>
                                <form id="signup_action" action="" method="post">
                                    <!-- ?= csrf_field() ? -->
									<input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

									<div class="col-6 col-12-xsmall">
										<input type="text" name="c_name" id="c_name" value="" placeholder="Name" />
										<label for="c_name" style="font=">* 영문자, 숫자, _만 입력가능. 최소 3자이상 입력하세요.<br>
									</div>

									<div class="col-6 col-12-xsmall">
										<input type="email" name="c_Email" id="c_Email" value="" placeholder="E-mail" />
										<br />
									</div>

									<div class="col-6 col-12-xsmall">
											<input type="text" name="c_id" id="c_id" value="" placeholder="아이디" />
											<label for="c_id" style="font=">* 영문자, 숫자만 입력가능. 최소 4자이상 입력하세요.</LABEL>
											<p><a href="javascript:requestsignup()" class="button primary">아이디 중복확인</a>&nbsp;</P>
									</div>

									<div class="col-6 col-12-xsmall">
										<input type="password" name="c_pw" id="c_pw" value="" placeholder="비밀번호" />
										<label for="c_pw">* 4자이상 이어야 합니다.</label>
									</div>

									<div class="col-6 col-12-xsmall">
										<input type="password" name="c_pwconf" id="c_pwconf" value="" placeholder="비밀번호 확인" />
										<label for="c_pwconf">* 동일한 패스워드를 입력해 주세요.</label>
									</div>

									<div class="col-6 col-12-xsmall">
										<input type="text" name="c_nick" id="c_nick" value="" placeholder="닉네임" /><br />
									</div>

                                    <label for="terms1">회원가입약관</label>
                                    <textarea name="terms1" cols="45" rows="3" readonly>회원가입해주셔서 감사합니다.</textarea><br />

									<div class="col-6 col-12-small">
										<input type="checkbox" id="acc_terms1" name="acc_terms1" >
										<label for="acc_terms1">회원가입약관의 내용에동의합니다.</label><br />
									</div>

                                    <label for="terms2">개인정보취급약관</label>
                                    <textarea name="terms2" cols="45" rows="3">개인정보취급방침 안내의 내용</textarea><br />

									<div class="col-6 col-12-small">
										<input type="checkbox" id="acc_terms2" name="acc_terms2">
										<label for="acc_terms2">개인정보취급방침 안내의 내용에동의합니다.</label><br />
									</div>

									<input type="submit" name="submit" value="회원가입" />

                                </form></p>
								<p>&nbsp;</p>

							</div>
						</section>
					</article>

<!-- BSG footer -->