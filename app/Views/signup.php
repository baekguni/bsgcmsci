<!-- BSG head -->
<!-- BSG menu -->

<!-- $(function(){	alert('jQuery Ready!'); }); -->

<script  type="text/javascript">
	
	function requestsuchk() {
	
		var csrfName = $('.txt_csrfname').attr('name');
		var csrfHash = $('.txt_csrfname').val();
		//alert(document.getElementById("c_id").value );

		$.ajax({
				url: "<?=base_url('signupchk')?>",
				method: 'post',
				type:'post',
				data: { 'custid' : document.getElementById("c_id").value , [csrfName]: csrfHash },
				dataType : 'json',
				success : function(res){
					if (res.success > 0) {
						if (res.cnt > 0) {
							alert("기존에 아이디가 있습니다. 다른 아이디를 사용해 주세요.");
							document.getElementById("c_id").focus();
						}else{
							alert("사용가능한 아이디입니다. 계속 진행해 주세요.");
							$('.chk_id').val(res.custidr);
							document.getElementById("c_pw").focus();							
						}
					}else{
						alert(res.error);
						document.getElementById("c_id").focus();
					}
					
					$('.txt_csrfname').val(res.chash);
					//alert(res.cnt);
					//alert(res.custidr);
				},
				error: function(xhr, status, error){
					console.log(xhr.status + ', '+xhr.responseText +', '+status+', '+error);
					alert(status);
				}
			});
	}

	function requestsignup() {
	
	var csrfName = $('.txt_csrfname').attr('name');
	var csrfHash = $('.txt_csrfname').val();
	//alert(document.getElementById("c_id").value );
	var chk_id_key = false;

	if(! document.getElementById("acc_terms1").checked){
		alert("회원가입약관을 동의하여 주세요");
	}

	if(! document.getElementById("acc_terms2").checked ){
		alert("개인정보취급약관을 동의하여 주세요");
	}

	if(document.getElementById("chk_id").value == "" || document.getElementById("c_id").value != document.getElementById("chk_id").value){
		alert("아이디 중복확인 버튼을 눌러 주세요");
	}else{
		chk_id_key = true;
	}

	if( document.getElementById("acc_terms2").checked && document.getElementById("acc_terms2").checked && chk_id_key){

		$.ajax({
				url: "<?=base_url('signupaj')?>",
				method: 'post',
				type:'post',
				data: { [csrfName]: csrfHash ,'c_id' : document.getElementById("c_id").value , 
					'c_name' : document.getElementById("c_name").value , 
					'c_email' : document.getElementById("c_email").value , 
					'c_pw' : document.getElementById("c_pw").value , 
					'c_pwconf' : document.getElementById("c_pwconf").value , 
					'c_nick' : document.getElementById("c_nick").value },
				dataType : 'json',
				success : function(res){
					$('.txt_csrfname').val(res.chash);
					if (res.success > 0) {
						if (res.result) {
							alert("회원가입이 완료되었습니다.");
							window.location.href = "<?=base_url('login')?>";
						}else{
							alert("회원가입이 실패하였습니다. 잠시 후 다시 진행하여 주십시요.");
							//document.getElementById("c_pw").focus();
						}
					}else{
						alert(res.error);
						document.getElementById(res.errorele).focus();
					}
					//alert(" 완료되었습니다.");
				},
				error: function(xhr, status, error){
					console.log(xhr.status + ', '+xhr.responseText +', '+status+', '+error);
					alert(status);
				}
			});
		} 
		// end of if
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
                                <!-- Trigger/Open The Modal -->
    							<!-- button id="openModalBtn">Open Modal</button>
								<p -->								
								<form id="signup_action" action="" method="post">
                                    <!-- ?= csrf_field() ? -->
									<input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
									<input type="hidden" class="chk_id" name="chk_id" id="chk_id" value="" />

									<div class="col-6 col-12-xsmall">
										<input type="text" name="c_name" id="c_name" value="" placeholder="Name" />
										<label for="c_name" style="font=">* 영문자, 숫자, _만 입력가능. 최소 3자이상 입력하세요.</label><br>
									</div>

									<div class="col-6 col-12-xsmall">
										<input type="email" name="c_email" id="c_email" value="" placeholder="E-mail" />
										<br />
									</div>

									<div class="col-6 col-12-xsmall">
											<input type="text" name="c_id" id="c_id" value="" placeholder="아이디" />
											<label for="c_id" style="font=">* 영문자, 숫자만 입력가능. 최소 4자이상 입력하세요.</label>
											<p><a href="javascript:requestsuchk()" class="button primary">아이디 중복확인</a>&nbsp;</P>
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
                                    <textarea name="terms1" id="terms1" cols="45" rows="3" readonly>회원가입해주셔서 감사합니다.</textarea><br />

									<div class="col-6 col-12-small">
										<input type="checkbox" id="acc_terms1" name="acc_terms1" >
										<label for="acc_terms1">회원가입약관의 내용에동의합니다.</label><br />
									</div>

                                    <label for="terms2">개인정보취급약관</label>
                                    <textarea name="terms2" id="terms2"  cols="45" rows="3">개인정보취급방침 안내의 내용</textarea><br />

									<div class="col-6 col-12-small">
										<input type="checkbox" id="acc_terms2" name="acc_terms2">
										<label for="acc_terms2">개인정보취급방침 안내의 내용에동의합니다.</label><br />
									</div>

									<!-- input type="submit" name="submit" value="회원가입" / -->
									<p><a href="javascript:requestsignup()" class="button primary">회원가입 AJAX</a>&nbsp;</P>

                                </form></p>
								<p>&nbsp;</p>

							</div>
						</section>
					</article>
<!-- BSG footer -->