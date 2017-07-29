	<div class="page-content-inner" style="background: url(<?php echo base_url();?>assets/common/img/temp/login/4.jpg) no-repeat center center fixed; width: 100%; height: 100%;background-size:cover">

    <!-- Login Omega Page -->
    <div class="single-page-block-header">
        <div class="row">
            <div class="col-lg-4">
                <div class="logo">
                    <a href="http://www.1qubit.com" target="_blank">
                        <img src="<?php echo base_url();?>assets/common/img/logo.png" alt="Parmar Oil Mills" />
                    </a>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="single-page-block-header-menu">
                    <ul class="list-unstyled list-inline">
                        <li><a href="javascript: void(0);">About</a></li>
                        <li><a href="javascript: void(0);">Support</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="single-page-block">
        <div class="single-page-block-inner effect-3d-element">
            <div class="blur-placeholder"><!-- --></div>
            <div class="single-page-block-form">
                <h3 class="text-center">
                    <i class="icmn-enter margin-right-10"></i>
                    Parmar Oil Mills
                </h3>
                <br />
				<?php $attributes = array('name' => 'form-validation'); echo form_open('ParmarOilMills/web/login/authenticate', $attributes); ?>
                <div id="form-validation">
                    <div class="form-group">
                        <input id="validation-username"
                               class="form-control"
                               placeholder="Username"
                               name="username"
                               type="text"
                               data-validation="[L>=3]"
                               data-validation-message="must be at least 3 characters"
							   onkeydown = "if (event.keyCode == 13)
								document.getElementById('btnLogin').click()">
                    </div>
                    <div class="form-group">
                        <input id="validation-password"
                               class="form-control password"
                               name="password"
                               type="password" data-validation="[L>=5]"
                               data-validation-message="must be at least 5 characters"
                               placeholder="Password"
							   onkeydown = "if (event.keyCode == 13)
								document.getElementById('btnLogin').click()">
                    </div>
					<b><span id = "userNotification" style = "color:red; font-size:15px;"></span></b>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary width-150">Sign In</button>
                    </div>
                </div>
				</form>
            </div>
        </div>
    </div>
    <div class="single-page-block-footer text-center">
        <ul class="list-unstyled list-inline">
            <li><a href="javascript: void(0);">Terms of Use</a></li>
            <li class="active"><a href="javascript: void(0);">Compliance</a></li>
            <li><a href="javascript: void(0);">Confidential Information</a></li>
            <li><a href="javascript: void(0);">Support</a></li>
            <li><a href="javascript: void(0);">Contacts</a></li>
        </ul>
    </div>
    <!-- End Login Omega Page -->

</div>

<!-- Page Scripts -->
<script>
    $(function() {

        // Add class to body for change layout settings
        $('body').addClass('single-page single-page-inverse');

        // Form Validation
        $('#form-validation').validate({
            submit: {
                settings: {
                    inputContainer: '.form-group',
                    errorListClass: 'form-control-error',
                    errorClass: 'has-danger'
                }
            }
        });

        // Show/Hide Password
        $('.password').password({
            eyeClass: '',
            eyeOpenClass: 'icmn-eye',
            eyeCloseClass: 'icmn-eye-blocked'
        });

        // Set Background Image for Form Block
        function setImage() {
            var imgUrl = $('.page-content-inner').css('background-image');

            $('.blur-placeholder').css('background-image', imgUrl);
        };

        function changeImgPositon() {
            var width = $(window).width(),
                    height = $(window).height(),
                    left = - (width - $('.single-page-block-inner').outerWidth()) / 2,
                    top = - (height - $('.single-page-block-inner').outerHeight()) / 2;


            $('.blur-placeholder').css({
                width: width,
                height: height,
                left: left,
                top: top
            });
        };

        setImage();
        changeImgPositon();

        $(window).on('resize', function(){
            changeImgPositon();
        });

        // Mouse Move 3d Effect
        var rotation = function(e){
            var perX = (e.clientX/$(window).width())-0.5;
            var perY = (e.clientY/$(window).height())-0.5;
            TweenMax.to(".effect-3d-element", 0.4, { rotationY:15*perX, rotationX:15*perY,  ease:Linear.easeNone, transformPerspective:1000, transformOrigin:"center" })
        };

        if (!cleanUI.hasTouch) {
            $('body').mousemove(rotation);
        }

    });
	function login(){
		document.getElementById('userNotification').innerHTML = "";
		if(document.getElementById('validation-username').value.length > 2
			&& document.getElementById('validation-password').value.length > 4){
				var username = document.getElementById('validation-username').value;
				var password = document.getElementById('validation-password').value;
				
				var request = new XMLHttpRequest();
				request.onreadystatechange = function(){
					if(request.readyState == 4 && request.status == 200){
						localStorage.setItem("token", request.response);						
						window.location = "home.html";
					} else if(request.readyState == 4 && request.status == 401){
						//window.location = "index.html";
						document.getElementById('userNotification').innerHTML = "Incorrect Username Or Password";
					}
				};
				request.open ("POST", base_url + "/AdValoramAdmin/authentication", true);				
				request.setRequestHeader("content-type", "application/x-www-form-urlencoded");
				request.send("username="+username + "&password="+password);
			}
	}
</script>
<!-- End Page Scripts -->