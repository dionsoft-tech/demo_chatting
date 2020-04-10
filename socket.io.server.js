var express = require('express');
var app = express();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var mysql = require('mysql');

/********************************************************
*					Client Page Loading					*
********************************************************/
app.get('/',function(req, res){
  res.sendFile(__dirname + '/client.html');
});

/********************************************************
*						DB Connect						*
********************************************************/
/*
const connDB = mysql.createConnection({
	host : 'localhost',
	user : 'chatdion',
	password : 'chatdionpw',
	database : 'chatting'
});
connDB.connect();
*/
const connDB = mysql.createConnection({
	host : '18.177.203.122',
	user : 'root',
	password : 'dion1234!',
	database : 'chatting'
});
connDB.connect();

const connDB2 = mysql.createConnection({
	host : '18.177.203.122',
	user : 'root',
	password : 'dion1234!',
	database : 'server_1'
});
connDB2.connect();

/********************************************************
*					Socket Server						*
********************************************************/
const namespace1 = io.of('namespace1');	//방 LIST 에서 사용 socket -  Namespace
const namespace2 = io.of('namespace2');	//방 입실에서 사용 socket - Namespace

var room_list;	//채팅방 목록
var loginUser_arr = new Array();	//채팅방 로그인 User 배열
var query;

///////////////////////////////////////////////////////////
////////// namespace1(방 LIST 에서 사용) Socket Connect
///////////////////////////////////////////////////////////
namespace1.on('connection', function(socket){

	console.log('\n[ namespace1 ] user connected: ', socket.id);
	//console.log('client list : ' + io.sockets.clients('room'));
	
	/****************************************
	*			Request : 유저 정보			*
	****************************************/
	socket.on('userInfo', function(data) {
		//console.log('1.event.userInfo');
		//console.log(data.user_type + ', ' + data.user_id);
		 
		query = "SELECT adm_01_pk AS pk, adm_01_name_kr AS name FROM tbl_admin_01 WHERE adm_01_id = '" + data.user_id + "'";
		
		// DB 유저 정보 select
		connDB2.query(query, function (error, result, fields) { 
			if (error) {
				console.log('1.select userInfo query error');
			} else { 
				//console.log('1.event.userInfo_res');
				socket.emit('userInfo_res', result);
			}
		});
	});

	/****************************************
	*			Request : 채팅방 목록			*
	****************************************/
	socket.on('roomList_req', function(data) {
		//console.log('1.event.roomList_req');
		
		// DB 채팅방 목록 select
		connDB.query("SELECT room_id, room_name, room_reg_timeStamp FROM tbl_roomList WHERE room_delYN = 'N' AND room_activeYN = 'Y' ORDER BY room_name ASC", function (error, result, fields) { 
			if (error) {
				//console.log('1.select room query error');
			} else { 
				//console.log('1.event.roomList_req');
				socket.emit('roomList_res', result);
			}
		});
	});
});

///////////////////////////////////////////////////////////
//////////	namespace1(방 입실 에서 사용) Socket Connect	
///////////////////////////////////////////////////////////
namespace2.on('connection', function(socket){

	console.log('\n[ namespace2 ] user connected: ', socket.id);
	//console.log('client list : ' + io.sockets.clients('room'));

	/****************************************
	*			Request : 유저 정보			*
	****************************************/
	socket.on('userInfo', function(data) {
		console.log('2.event.userInfo');
		
		if (data.user_type == '1') {
			query = "SELECT adm_01_pk AS pk, adm_01_name_kr AS name, (SELECT client_01_name_kr FROM tbl_client_01 WHERE client_01_delYN = 'N' AND client_01_pk = '" + data.roomId + "') AS room_name FROM tbl_admin_01 WHERE adm_01_id = '" + data.user_id + "'";
		} else { 
			query = "SELECT client_01_pk AS pk, client_01_name_kr AS name, (SELECT client_01_name_kr FROM tbl_client_01 WHERE client_01_delYN = 'N' AND client_01_pk = '" + data.roomId + "') AS room_name FROM tbl_client_01 WHERE client_01_id = '" + data.user_id + "'";
		}
		
		//console.log(query);

		// DB 유저 정보 select
		connDB2.query(query, function (error, result, fields) { 
			if (error) {
				console.log('2.select userInfo query error');
			} else { 
				//console.log('2.event.userInfo_res');
				socket.emit('userInfo_res', result);
			}
		});
	});
	
	/****************************************
	*				채팅방 입장					*
	****************************************/
	socket.on("roomJoin", function(data) {

		console.log('2.event.roomJoin');
		//console.log('[ before ] : ');
		//console.log(socket.adapter.rooms);

		socket.leave(socket.id);
		socket.join(data.roomId);	//채팅방 입장

		//console.log('[ after ] : ');
		//console.log(socket.adapter.rooms);
		
		// 채팅방 입장 유저 Array
		loginUser_arr.push({
			'socket' : socket.id,			// 생성된 socket.id
			'roomId' : data.roomId,			// 접속한 채팅방의 ID
			'roomName' : data.roomName,		// 접속한 채팅방의 이름
			'user_type' : data.user_type,	// 접속자의 유저의 Type (1 : Actor1, 2 : Actor2(가맹점관리자))
			'user_pk' : data.user_pk,		// 접속자의 유저의 DB pk
			'user' : data.user_name			// 접속자의 유저의 이름
		});

		//console.log(data.roomId.length);


		// 사용자가 페이지 새로고침시 loginUser_arr 변수에 값이 누적되지 않게 동일한 사용자의 socket.id 값을 삭제한다.
		for(var num in loginUser_arr) {
			
			//console.log(num + ' : ' + loginUser_arr[num]['user'] + ' , ' + data.user_name + ' | ' + loginUser_arr[num]['socket'] + ' , ' + socket.id);

			// 사용자 이름이 같으면서, 기존소켓아이디와 현재 소켓아이디가 다른 값이 있는지 찾아낸다.
			if(loginUser_arr[num]['user'] == data.user_name && loginUser_arr[num]['socket'] != socket.id) {
			   
				// loginUser_arr의 해당 순서의 값을 삭제한다.
				loginUser_arr.splice(num, 1);
				socket.leave(loginUser_arr[num]['socket']);	// 이전 socket.id 가 남아있는 방 퇴장 처리
			}
		}

		// 기존 Chatting 방 있는지 확인
		var room_exist = false;

		//console.log(data.roomId);

		// DB 채팅방 조회 select
		query = "SELECT room_pk, room_id, room_name, room_reg_timeStamp FROM tbl_roomList WHERE room_delYN = 'N' AND room_activeYN = 'Y' AND room_id = '" + data.roomId + "'";
		//console.log(query);
		connDB.query(query, function (error, result, fields) { 
			if (error) {
				console.log('2.select room_exist query error');
			} else { 
				
				// 기존 채팅방 있음
				if (result.length > 0) {
					room_exist = true;

					//console.log('AAAA room_pk : ' + result[0]['room_pk']);
					
					// DB 채팅방 대화 기록 조회 select
					query = "SELECT cLog_reg_timeStamp, cLog_msgType, cLog_userType, cLog_userPK, cLog_userNickname, cLog_message";
					query += ", FROM_UNIXTIME( CAST(cLog_reg_timeStamp AS UNSIGNED) + 32400, '%Y-%m-%d') AS kst_date";
					query += ", FROM_UNIXTIME( CAST(cLog_reg_timeStamp AS UNSIGNED) + 32400, '%H:%i') AS kst_time";
					query += " FROM tbl_chatLog_01 WHERE cLog_delYN = 'N' AND cLog_room_fk = '" + result[0]['room_pk'] + "'";
					query += " ORDER BY cLog_reg_timeStamp ASC";
					
					//console.log(query);

					connDB.query(query, function (error2, result2, fields2) {
						if (error2) {
							console.log('2.select tbl_chatLog_01 query error');
						} else { 
							if (result2.length > 0) {
								//console.log('2.event.receive history');

								socket.emit('receive history', result[0]['room_pk'], result2);
								//io.sockets.in(data.roomId).emit('receive history', result);
							}
						}
					});

				// 기존 채팅방 없음 => New 채팅방 생성
				} else { 

					// DB : New 채팅방 Insert
					connDB.query("INSERT INTO tbl_roomList (room_id, room_name, room_delYN, room_reg_timeStamp) VALUES  (?, ?, ?, ?)", [ data.roomId, data.roomName, 'N', data.date ], function (error, result, fields) { 
						if (error) {
							console.log('2. INSERT room query error');
						} else {

							var insertId = result.insertId;

							//console.log('new insertId : ' + result.insertId);
							
							var msg = data.user_name + ' 님이 입장하였습니다.';

							//console.log('roomId : ' + data.roomId + ', date : ' + data.date  + ', user_type :' + data.user_type + ', user_pk : ' + data.user_pk + ', user_name : ' + data.user_name + ', msg : ' + msg);

							// DB 채팅 History insert
							connDB.query("INSERT INTO tbl_chatLog_01 (cLog_room_fk, cLog_room_id, cLog_reg_timeStamp, cLog_msgType, cLog_userType, cLog_userPK, cLog_userNickname, cLog_message, cLog_delYN) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", [
								insertId, data.roomId, data.date, 'S', data.user_type, data.user_pk, data.user_name, msg, 'N'
							  ], function (error2, result2, fields2) { 

								if (error2) {
									console.log('INSERT tbl_chatLog_01 query error2');
								}
							});

							// 클라이언트의 Contact 이벤트를 실행하여 입장한 사용자의 정보를 출력한다.
							io.of('namespace2').in(data.roomId).emit('new enter', {
								'count' : io.sockets.adapter.rooms[data.roomId],	//socket connection 수
								'room_pk' : insertId,						//방 PK
								'roomId' : data.roomId,								//방 ID
								'roomName' : data.roomName,							//방 제목
								'sysMsg' : data.user_name + "님이 입장하였습니다."	//System Message
							});
						}
					});
				}

			}
		});


		/*
		// 실제 접속한 유저 수만 체크하려면..?
		11111, 13 , 테스트 가맹점 2  
		22222, 13 , 테스트 가맹점 2  
		33333, 13 , 테스트 가맹점 1 
		
		var newArr = loginUser_arr.filter(function(item){    
		  return (item.room === data.roomId) && (item.user === data.user_name);
		});  

		var newArr = loginUser_arr.filter(function(item){    
		  return (item.room === data.roomId) && (item.user != data.user_name);
		});  
		console.log('newArr : ' + newArr.length);
		*/

	});
	
	/****************************************
	*				메세지 보내기				*
	****************************************/
	socket.on('send message', function(data){
		console.log('2. event.send message : ' + data.room_pk + ', ' + data.roomId);

		//console.log('room_pk : ' + data.room_pk + ', roomId : ' + data.roomId + ', date : ' + data.date + ', msgType : ' + data.msgType  + ', user_type :' + data.user_type + ', user_pk : ' + data.user_pk + ', user_name : ' + data.user_name + ', message : ' + data.message);

		// DB 채팅 History insert
		connDB.query("INSERT INTO tbl_chatLog_01 (cLog_room_fk, cLog_room_id, cLog_reg_timeStamp, cLog_msgType, cLog_userType, cLog_userPK, cLog_userNickname, cLog_message, cLog_delYN) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", [
            data.room_pk, data.roomId, data.date, data.msgType, data.user_type, data.user_pk, data.user_name, data.message, 'N'
          ], function (error, result, fields) { 

			if (error) {
				console.log('INSERT tbl_chatLog_01 query error');
			}
		});

		var msg2 = data.message.replace(/(?:\r\n|\r|\n)/g, '<br>');
		//console.log(msg2);

		//var msg = name + ' : ' + msg2;

		var sendMsg = new Array();

		sendMsg.push({
			sendUser : data.user_name, 
			msg : msg2  
		});

		//socket.emit('receive message', sendMsg);
		//io.sockets.in(data.roomId).emit('receive message', sendMsg);
		//socket.in(data.roomId).emit('receive message', sendMsg);
		io.of('namespace2').in(data.roomId).emit('receive message', sendMsg);
	});



	 // 채팅방 퇴장시 실행(Node.js에서 사용자의 Disconnect 이벤트는 사용자가 방을 나감과 동시에 이루어진다.)
    socket.on("roomExit", function(data) {

		console.log('2.event roomExit');
		//console.log('exitType : ' + data.exitType);
     
	 	if (data.exitType == 'exit') {
			//console.log('user_type : ' + data.user_type + ', user_pk : ' + data.user_pk + ', roomId : ' + data.roomId);
			
			if (data.user_type == 2) {
				query = "UPDATE tbl_roomList SET room_activeYN = 'N' WHERE room_pk = '" + data.room_pk + "'";
				
				var rs = new Array();

				// DB 채팅 History insert
				connDB.query(query, function (error, result, fields) { 
					//console.log(query);
					if (error) {
						console.log('UPDATE tbl_roomList Active N query error');
						rs.push({
							'result' : false
						});
						io.of('namespace2').in(data.roomId).emit('exit update', rs);
					} else { 
						//console.log('SUCCESS. update db');

						var msg = data.user_name + " 님이 퇴장하였습니다.";

						// DB 채팅 History insert
						connDB.query("INSERT INTO tbl_chatLog_01 (cLog_room_fk, cLog_room_id, cLog_reg_timeStamp, cLog_msgType, cLog_userType, cLog_userPK, cLog_userNickname, cLog_message, cLog_delYN) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", [
							data.room_pk, data.roomId, data.date, 'S', data.user_type, data.user_pk, data.user_name, msg, 'N'
						  ], function (error2, result2, fields2) { 
							if (error2) {
								console.log('INSERT tbl_chatLog_01 query error2');
							}
						});

						rs.push({
							'result' : true,
							'sysMsg' : msg		//System Message
						});

						io.of('namespace2').in(data.roomId).emit('exit update', rs);
					}
				});
			}

		}
	});

	 // 채팅방 퇴장시 실행(Node.js에서 사용자의 Disconnect 이벤트는 사용자가 방을 나감과 동시에 이루어진다.)
    socket.on("disconnect", function(data) {

        var socket = "";
        var count = 0;

        var room = "";
		var roomId = "";
        var user_type = "";
        var user_pk = "";
        var user = "";
		

		console.log('2.event disconnet');

        try {
           
            // 생성된 방의 수만큼 반복문을 돌린다.
            for(var key in io.sockets.adapter.rooms) {

                // loginUser_arr 배열의 값만큼 반복문을 돌린다.
                var members = loginUser_arr.filter(function(chat) {
                    return chat.room === key;
                });
   
                // 현재 소켓 방의 length와 members 배열의 갯수가 일치하지 않는경우
                if(io.sockets.adapter.rooms[key].length != members.length) {
               
                    // 반복문으로 loginIds에 해당 socket.id값의 존재 여부를 확인한다.
                    for(var num in loginUser_arr) {

                        // 일치하는 socket.id의 정보가 없을경우 그 사용자가 방에서 퇴장한것을 알 수 있다.
                        if(io.sockets.adapter.rooms[key].sockets.hasOwnProperty(loginUser_arr[num]['socket']) == false) {

                            // 퇴장한 사용자의 정보를 변수에 담는다.
                            room = key;
                            roomId = loginUser_arr[num]['roomId'];
                            user_type = loginUser_arr[num]['user_type'];
                            user_pk = loginUser_arr[num]['user_pk'];
                            user = loginUser_arr[num]['user'];


                            // loginIds 배열에서 퇴장한 사용자의 정보를 삭제한다.
                            loginUser_arr.splice(num, 1);
                        }
                    }
                   
                    // 해당 방의 인원수를 다시 구한다.
                    count = io.sockets.adapter.rooms[key].length;
                }
            }

        } catch(exception) {

            console.log(exception);

        } finally {

			//console.log('EXIT - user_type : ' + user_type + ', user_pk : ' + user_pk + ', roomId : ' + roomId);

			/*
            // 클라이언트의 Contact 이벤트를 실행하여 이탈한 사용자가 누군지 알린다.
            io.sockets.in(room).emit("contact", {
                  count : count
                , name : name
                , message : name + "님이 채팅방에서 나갔습니다."
            });
           */
        }
	});
});

var port = process.env.PORT || 52273;
http.listen(port, function(){
  console.log('NodeJS Chatting Server By Dion Chatting Start');
});
