// JavaScript Document
$(function(){
});

/*******************************
*		참조 정보 Data Get		*
* (찾을 데이터, return 타입, 셋팅할 dom 타입, 셋팅할 dom ID, where 값 1, where 값 2, dom 에 선택되어야 할 값-select 박스)
*******************************/
function get_referData(dataGubun, returnType, dom_type, dom_id, where_val_1, where_val_2, sel_val)
{   
    $.ajax({
        type: 'post',
        url: '/common/Get_refer_data',
        data : {'dataGubun' : dataGubun, "returnType" : returnType, "where_val_1" : where_val_1, "where_val_2" : where_val_2},
        dataType: returnType,
        success: function(result) {	
            //console.log(result);
            if (result) {
                set_referData_1(dom_type, dom_id, result, sel_val);
            }
        },
        error: function(result) {
            alert('데이러를 불러오는 중 오류가 발생되었습니다.');	
        }
    });
}

/*******************************
*		참조 정보 Data Set		*
*******************************/
function set_referData_1(dom_type, dom_id, result, sel_val)
{
    var data = [];

    if (dom_type != null && dom_id != null && result != null) {


        data['total_count'] = result['total_count'];
        data['list'] = result['list'];
    
        //console.log(data['list']);

        if (dom_type == 'select') { 

            var targetObj = document.getElementById(dom_id);
            var objOption = "";
            var i;

            $('#' + dom_id).empty();

            objOption = document.createElement("OPTION");
            
            objOption.text = '-- 선택하세요 --';
            objOption.value = '';
            targetObj.add(objOption);
            
            if(data['list'] != null){
                for(i=0; i<data['list'].length; i++){

                    objOption = document.createElement("OPTION");
                    objOption.text = data['list'][i]['text'];
                    objOption.value = data['list'][i]['pk'];
                    targetObj.add(objOption);
                    
                    if(data['list'][i]['pk'] == sel_val){
                        document.getElementById(dom_id).options[i+1].selected = true;
                       // $("#" + dom_id + "_txt").html(data['list'][i]['text']);
                    }
                }
            }

            sel_val
        
        } else if (dom_type == '') { 

        }
    }
}