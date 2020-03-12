// JavaScript Document
$(function(){
});

/****************************************
*			Daum 우편번호/주소 찾기			*
****************************************/
function execDaumPostcode() {
	new daum.Postcode({
		oncomplete: function(data) {
			// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

			// 도로명 주소의 노출 규칙에 따라 주소를 표시한다.
			// 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
			var roadAddr = data.roadAddress; // 도로명 주소 변수
			var extraRoadAddr = ''; // 참고 항목 변수

			// 법정동명이 있을 경우 추가한다. (법정리는 제외)
			// 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
			if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
				extraRoadAddr += data.bname;
			}
			// 건물명이 있고, 공동주택일 경우 추가한다.
			if(data.buildingName !== '' && data.apartment === 'Y'){
			   extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
			}
			// 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
			if(extraRoadAddr !== ''){
				extraRoadAddr = ' (' + extraRoadAddr + ')';
			}

			// 우편번호와 주소 정보를 해당 필드에 넣는다.
			document.getElementById('client_01_postcode').value = data.zonecode;
			document.getElementById("client_01_address1_d").value = roadAddr;
			document.getElementById("client_01_address1_j").value = data.jibunAddress;
			document.getElementById("chn_postcode").value = "Y";
		}
	}).open();
}

/*************************************
*               Search               *
*************************************/
function search()
{
  var f = document.search_form;
  

}

/**************************************
*             Page move               *
**************************************/
function page_move(type, url, pk, table_id)
{
  var link;

  // Page 이동
  if (type == 'detail') {
    link = url + '&' + pk; 
  } else if (type == 'update') { 
    link = url + '&' + pk; 
  } else if (type == 'delete') { 
    swal({
        title: '삭제하시겠습니까?',
        text: "삭제 후 복구가 불가합니다.",
        type: 'warning',
        buttons:{
            cancel: {
                visible: true,
                text : 'No, cancel!',
                className: 'btn btn-danger'
            },        			
            confirm: {
                text : 'Yes, delete it!',
                className : 'btn btn-success'
            }
        }
    }).then((willDelete) => {
        if (willDelete) {
          location.href = url + '&' + pk;
        }
    });

    return false;

  } else if (type == 'list') { 
    link = url;
  }
  
  // Paging 정보
  if (table_id) {
    var rs = $('#' + table_id).DataTable().page.info();
    console.log(rs);
    console.log(rs.start);
    link += '&start=' + rs.start;
  }
  
  location.href = link;
}

/**************************************
*       Datatables : Paging Info      *
**************************************/
function paging_info(table_id)
{
  var rs = $('#' + table_id).DataTable().page.info();
  return rs;
}

/**********************************
*		알림창 - notification		*
**********************************/
function notification (_from, _align, _style, _state, _title, _msg, _time, _delay, _url, _target) { 

	// options
    var content = {};

    content.title = _title;
    content.message = _msg;

    if (_style == "withicon") {
		if (_state == "success") {
			content.icon = 'fas fa-grin-beam';
		} else if (_state == "warning") { 
			content.icon = 'fa fa-times-circle';
		} else { 
       		content.icon = 'fa fa-bell';
		}
    } else {
		content.icon = 'none';
    }
	
	if (_url != '')		content.url = _url;
	if (_target != '')	content.target = _target;	//_blank | _self | _parent | _top

    $.notify(content,{
		// settings
        type: _state,
        placement: {
            from: _from,
            align: _align
        },
        time: _time,
        delay: _delay,
		z_index : 9999999999999999999,
    });
};