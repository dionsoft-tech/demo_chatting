<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//chk_login($this->session->LOGIN_SEQNO);
?>
<!-- sidebar_minimize -->
<div class="wrapper "> 
	<div class="main-header">
		<!--------------------------------------------
		--					Logo Header				--
		--------------------------------------------->
		<div class="logo-header" data-background-color="dark">
			<a href="/main/Main" class="logo">
				<img src="../assets/img/dion_logo.png" alt="navbar brand" class="navbar-brand">
			</a>
			<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon">
					<i class="icon-menu"></i>
				</span>
			</button>
			<button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
			<div class="nav-toggle">
				<button class="btn btn-toggle toggle-sidebar">
					<i class="icon-menu"></i>
				</button>
			</div>
		</div>
		<!-- End Logo Header -->

		<!-------------------------------------------
		--		Navbar Header : 상단 오른쪽 메뉴	--
		-------------------------------------------->
		<nav class="navbar navbar-header navbar-expand-lg" data-background-color="dark2">
			<div class="container-fluid">
				<div class="collapse" id="search-nav">
					<!--
					<form class="navbar-left navbar-form nav-search mr-md-3">
						<div class="input-group">
							<div class="input-group-prepend">
								<button type="submit" class="btn btn-search pr-1">
									<i class="fa fa-search search-icon"></i>
								</button>
							</div>
							<input type="text" placeholder="Search ..." class="form-control">
						</div>
					</form>
					-->
				</div>
				<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
					<li class="nav-item toggle-nav-search hidden-caret">
						<a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false" aria-controls="search-nav">
							<i class="fa fa-search"></i>
						</a>
					</li>
					<li class="nav-item dropdown hidden-caret">
						<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
							<div class="avatar-sm">
							<span class="avatar-title rounded-circle" style="border:3px solid #fff;color:#fff;"><?=substr($this->session->LOGIN_NAME, 0, 3)?></span>
							</div>
						</a>
						<ul class="dropdown-menu dropdown-user animated fadeIn">
							<div class="dropdown-user-scroll scrollbar-outer">
								<li>
									<a class="dropdown-item" href="/auth/My_page">My Page</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="/auth/Logout">Log Out</a>
								</li>
							</div>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
		<!-- End Navbar -->
	</div>
		
	<!---------------------------------------------
	--			Sidebar : 레프트 메뉴			--
	---------------------------------------------->
	<div class="sidebar sidebar-style-2" data-background-color="dark2">			
		<div class="sidebar-wrapper scrollbar scrollbar-inner">
			<div class="sidebar-content">
				<div class="user">
					<div class="avatar-sm float-left mr-2">
						<span class="avatar-title rounded-circle border border-white"><?=substr($this->session->LOGIN_NAME, 0, 3)?></span>
					</div>
					<div class="info">
						<a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
							<span>
								<?=$this->session->LOGIN_NAME?>
								<span class="user-level">Level <?=$this->session->LOGIN_LEVEL?></span>
								<span class="caret"></span>
							</span>
						</a>
						<div class="clearfix"></div>

						<div class="collapse in" id="collapseExample">
							<ul class="nav">
								<li>
									<a href="/auth/My_page">
										<span class="link-collapse">My Page</span>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<ul class="nav nav-primary">
					<!-- Dashboard -->
					<li class="nav-item" id="menu_dashboard">
						<a href="/main/Main" class="collapsed" aria-expanded="false">
							<i class="fas fa-home"></i>
							<p>Dashboard</p>
							<span></span>
						</a>
					</li>
					<!-- Menu -->
					<li class="nav-section">
						<span class="sidebar-mini-icon">
							<i class="fa fa-ellipsis-h"></i>
						</span>
						<h4 class="text-section">Menu</h4>
					</li>
					<li class="nav-item" id="menu_admin">
						<a data-toggle="collapse" href="#sub_admin">
							<i class="fas fa-user-friends"></i>
							<p>관리자 관리</p>
							<span class="caret"></span>
						</a>
						<div class="collapse" id="sub_admin">
							<ul class="nav nav-collapse">
								<li id="sub_admin_list">
									<a href="/admin/Admin_list">
										<span class="sub-item">계정 관리</span>
									</a>
								</li>
							</ul>
						</div>
					</li>
					
					<!-- 고객 관리 메뉴 -->
					<li class="nav-item" id="menu_client">
						<a data-toggle="collapse" href="#sub_client">
							<i class="fas fas fa-user-tie"></i>
							<p>고객 관리</p>
							<span class="caret"></span>
						</a>
						<div class="collapse" id="sub_client">
							<ul class="nav nav-collapse">
								<li id="sub_client_list">
									<a href="/client/Client_list">
										<span class="sub-item">가맹점(고객사) 관리</span>
									</a>
								</li>
								<li id="sub_customer_list">
									<a href="/customer/Customer_list">
										<span class="sub-item">고객 관리</span>
									</a>
								</li>
							</ul>
						</div>
					</li>
					
					<!-- 예약 통계 메뉴 -->
					<li class="nav-item" id="menu_booking">
						<a data-toggle="collapse" href="#sub_booking">
							<i class="far fa-calendar-alt"></i>
							<p>예약 통계</p>
							<span class="caret"></span>
						</a>
						
						<div class="collapse" id="sub_booking">
							<ul class="nav nav-collapse">
								<li id="sub_booking_stat_month">
									<a href="/booking/Booking_stat_month">
									<!--<a href="#" onClick="alert('준비중입니다.');">-->
										<span class="sub-item">예약 통계 (월별)</span>
									</a>
								</li>
								<li id="sub_booking_stat_client">
									<!--<a href="/reserv/Reserv_status_client">-->
									<a href="#" onClick="alert('준비중입니다.');">
										<span class="sub-item">예약 통계 (가맹점별)</span>
									</a>
								</li>
								<li id="sub_booking_stat_area">
									<!--<a href="/reserv/Reserv_status_area">-->
									<a href="#" onClick="alert('준비중입니다.');">
										<span class="sub-item">예약 통계 (지역별)</span>
									</a>
								</li>
							</ul>
						</div>
					</li>
					
					<!-- 매출 통계 메뉴 -->
					<li class="nav-item" id="menu_sales">
						<a data-toggle="collapse" href="#sub_sales">
							<i class="fas fa-chart-bar"></i>
							<p>매출 통계</p>
							<span class="caret"></span>
						</a>
						
						<div class="collapse" id="sub_sales">
							<ul class="nav nav-collapse">
								<li id="sub_sales_status_month">
									<!--<a href="/sales/Sales_status_month">-->
									<a href="#" onClick="alert('준비중입니다.');">
										<span class="sub-item">매출 통계 (월별)</span>
									</a>
								</li>
								<li id="sub_sales_status_client">
									<!--<a href="/sales/Sales_status_client">-->
									<a href="#" onClick="alert('준비중입니다.');">
										<span class="sub-item">매출 통계 (가맹점별)</span>
									</a>
								</li>
								<li id="sub_sales_status_area">
									<!--<a href="/sales/Sales_status_area">-->
									<a href="#" onClick="alert('준비중입니다.');">
										<span class="sub-item">매출 통계 (지역별)</span>
									</a>
								</li>
							</ul>
						</div>
					</li>
					
					<!-- 고객 센터 메뉴 -->
					<li class="nav-item" id="menu_cs">
						<a data-toggle="collapse" href="#sub_cs">
							<i class="fas fa-seedling"></i>
							<p>고객 센터</p>
							<span class="caret"></span>
						</a>
						
						<div class="collapse" id="sub_cs">
							<ul class="nav nav-collapse">
								<li id="sub_cs_online">
									<a href="#" onClick="alert('준비중입니다.');">
										<span class="sub-item">고객 문의</span>
									</a>
								</li>
							</ul>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- End Sidebar -->
	
	<div class="main-panel">
		<div class="content">
			<?php echo $html['output']; ?>
		</div>
		<footer class="footer">
			<div class="container-fluid">
				<!--
				<nav class="pull-left">
					<ul class="nav">
						<li class="nav-item">
							<a class="nav-link" href="https://www.themekita.com">
								ThemeKita
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">
								Help
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">
								Licenses
							</a>
						</li>
					</ul>
				</nav>
				<div class="copyright ml-auto">
					2018, made with <i class="fa fa-heart heart text-danger"></i> by <a href="https://www.themekita.com">ThemeKita</a>
				</div>	
				-->			
			</div>
		</footer>
	</div>

	<!-- Custom template | don't include it in your project! -->
	<div class="custom-template">
		<div class="title">Settings</div>
		<div class="custom-content">
			<div class="switcher">
				<div class="switch-block">
					<h4>Logo Header</h4>
					<div class="btnSwitch">
						<button type="button" class="changeLogoHeaderColor" data-color="dark"></button>
						<button type="button" class="selected changeLogoHeaderColor" data-color="blue"></button>
						<button type="button" class="changeLogoHeaderColor" data-color="purple"></button>
						<button type="button" class="changeLogoHeaderColor" data-color="light-blue"></button>
						<button type="button" class="changeLogoHeaderColor" data-color="green"></button>
						<button type="button" class="changeLogoHeaderColor" data-color="orange"></button>
						<button type="button" class="changeLogoHeaderColor" data-color="red"></button>
						<button type="button" class="changeLogoHeaderColor" data-color="white"></button>
						<br/>
						<button type="button" class="changeLogoHeaderColor" data-color="dark2"></button>
						<button type="button" class="changeLogoHeaderColor" data-color="blue2"></button>
						<button type="button" class="changeLogoHeaderColor" data-color="purple2"></button>
						<button type="button" class="changeLogoHeaderColor" data-color="light-blue2"></button>
						<button type="button" class="changeLogoHeaderColor" data-color="green2"></button>
						<button type="button" class="changeLogoHeaderColor" data-color="orange2"></button>
						<button type="button" class="changeLogoHeaderColor" data-color="red2"></button>
					</div>
				</div>
				<div class="switch-block">
					<h4>Navbar Header</h4>
					<div class="btnSwitch">
						<button type="button" class="changeTopBarColor" data-color="dark"></button>
						<button type="button" class="changeTopBarColor" data-color="blue"></button>
						<button type="button" class="changeTopBarColor" data-color="purple"></button>
						<button type="button" class="changeTopBarColor" data-color="light-blue"></button>
						<button type="button" class="changeTopBarColor" data-color="green"></button>
						<button type="button" class="changeTopBarColor" data-color="orange"></button>
						<button type="button" class="changeTopBarColor" data-color="red"></button>
						<button type="button" class="changeTopBarColor" data-color="white"></button>
						<br/>
						<button type="button" class="changeTopBarColor" data-color="dark2"></button>
						<button type="button" class="selected changeTopBarColor" data-color="blue2"></button>
						<button type="button" class="changeTopBarColor" data-color="purple2"></button>
						<button type="button" class="changeTopBarColor" data-color="light-blue2"></button>
						<button type="button" class="changeTopBarColor" data-color="green2"></button>
						<button type="button" class="changeTopBarColor" data-color="orange2"></button>
						<button type="button" class="changeTopBarColor" data-color="red2"></button>
					</div>
				</div>
				<div class="switch-block">
					<h4>Sidebar</h4>
					<div class="btnSwitch">
						<button type="button" class="selected changeSideBarColor" data-color="white"></button>
						<button type="button" class="changeSideBarColor" data-color="dark"></button>
						<button type="button" class="changeSideBarColor" data-color="dark2"></button>
					</div>
				</div>
				<div class="switch-block">
					<h4>Background</h4>
					<div class="btnSwitch">
						<button type="button" class="changeBackgroundColor" data-color="bg2"></button>
						<button type="button" class="changeBackgroundColor selected" data-color="bg1"></button>
						<button type="button" class="changeBackgroundColor" data-color="bg3"></button>
						<button type="button" class="changeBackgroundColor" data-color="dark"></button>
					</div>
				</div>
			</div>
		</div>
		<div class="custom-toggle">
			<i class="flaticon-settings"></i>
		</div>
	</div>
	<!-- End Custom template -->
</div>