<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            width: 100%;
        }

        .main {
            width: 1200px;
            height: 900px;
            margin: 0 auto;
            border: 1px solid;
        }

        .title {
            line-height: 40px;
            height: 40px;
            text-align: center;
            border: 1px solid;

        }

        .container {
            width: 100%;
            height: 858px;
            overflow: hidden;
        }

        .container-div {
            float: left;
            border: 1px solid;
            height: 100%;
        }

        .left-bar {
            width: 198px;
        }

        .left-bar h4 {
            width: 100%;
            height: 30px;
            line-height: 30px;
            border-bottom: 1px solid;
            text-align: center;
        }

        .left-bar ul {
            list-style: none;
            margin: 10px 5px;
        }

        .left-bar ul li {
            margin: 5px 0;
            text-align: center;
        }

        .middle {
            width: 798px;
            position: relative;
        }

        .middle .chat-board {
            height: 70%;
            border-bottom: 1px solid;
            overflow: hidden;
        }

        .middle .chat-board .system-msg {
            height: 80px;
            /* line-height: 50px; */
            overflow-y: scroll;
            width: 100%;
            border-bottom: 1px solid;
        }

        .middle .chat-board .chat-wrapper {
            height: 515px;
            overflow-y: scroll;
        }

        .chat-wrapper .left {
            margin-bottom: 5px;
            padding: 5px;
            background-color: rgba(39, 133, 78, 0.418);
        }

        .chat-wrapper .right {
            margin-bottom: 5px;
            padding: 5px;
            background-color: rgba(109, 186, 231, 0.39);
        }

        .chat-wrapper .sys {
            margin-bottom: 5px;
            padding: 5px;
            background-color: gray;
        }

        .middle .input-box textarea {
            resize: none;
            width: 99%;
            margin: 5px auto;
            box-sizing: border-box;
            height: 200px;
            padding: 5px;
            display: block;
        }

        .middle .input-box button {
            width: 80px;
            height: 30px;
            position: absolute;
            right: 5px;
            bottom: 10px;
        }

        .right-bar {
            width: 198px;
        }

        .avatar {
            width: 80px;
            height: 80px;
            margin: 40px auto;
            background-color: plum;
        }

        .right-bar dl dd {
            text-align: center;
        }
    </style>
</head>
<div class="main">
    <div class="title">XXX聊天室 <span id="status" style="color: red;">未连接</span></div>
    <div class="container">
        <div class="left-bar container-div">
            <h4>在线用户</h4>
            <div class="user-list">
                <ul>
                    <li>
                        <span>用户1</span>
                    </li>
                    <li>
                        <span>用户1</span>
                    </li>
                    <li>
                        <span>用户1</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="middle container-div">
            <div class="chat-board">
                <div class="system-msg">系统消息</div>
                <div class="chat-wrapper" id="chatWrapper">
                </div>
            </div>
            <div class="input-box">
                <textarea id="sayText"></textarea>
                <button id="send-btn">发送</button>
            </div>
        </div>
        <div class="right-bar container-div">
            <div class="avatar"></div>
            <dl>
                <dd>用户名：<span id="username">xxx</span></dd>
            </dl>
        </div>
    </div>
</div>

<body>

</body>
<script src="/static/axios.min.js"></script>
<script src="/static/conf.js"></script>

<script>
    let name = prompt('请输入用户名');

    if (name) {

        axios.post(URL + '/user-info/login', {
                name
            }
        )
            .then(function (response) {
                if (response.data.code === REQ_OK) {
                    // Create WebSocket connection.
                    const socket = new WebSocket('ws://localhost:9502/' + name);
                    if (socket) {
                        clickSend(socket);
                    }

                    // Connection opened
                    socket.addEventListener('open', function (event) {
                        // socket.send('Hello Server!');
                        initShow(name);
                    });

                    // Listen for messages
                    socket.addEventListener('message', function (event) {
                        let data = JSON.parse(event.data);
                        switch (data.type) {
                            case 1 :
                                sysSay(data.msg, data.time);
                                break;
                            case 2 :
                                otherSay(data.msg, data.name, data.time);
                                break;
                        }


                        // console.log('Message from server ', event.data);
                    });


                } else {
                    alert('连接错误');
                }
            })
            .catch(function (error) {
                console.log(error);
            });
    }

    function clickSend(socket) {

        let sendBtn = document.querySelector('#send-btn');

        sendBtn.addEventListener('click', function () {
            let sayText = document.querySelector('#sayText').value;
            if (sayText.length > 0) {
                iSay(sayText);
                socket.send(sayText);
                sayText.value = '';
            }

        });


    }


    function initShow(name) {
        let status = document.querySelector('#status');
        let username = document.querySelector('#username');
        if (!name) {
            status.innerText = '未连接';
        } else {
            status.innerText = '已连接';
            status.style.color = 'black';
            username.innerText = name;
        }
    }


    function iSay(msg) {
        let chatWrapper = document.querySelector('#chatWrapper');
        let div = document.createElement('div');
        div.className = 'right';
        div.appendChild(document.createTextNode('我说: ' + msg));
        chatWrapper.appendChild(div);
        chatWrapper.scrollTop += 100;
    }

    function otherSay(msg, name, time) {
        let chatWrapper = document.querySelector('#chatWrapper');
        let div = document.createElement('div');
        div.className = 'left';
        div.appendChild(document.createTextNode(name + '说: ' + msg + ' ' + time));
        chatWrapper.appendChild(div);
        chatWrapper.scrollTop += 100;
    }

    function sysSay(msg, time) {
        let chatWrapper = document.querySelector('#chatWrapper');
        let div = document.createElement('div');
        div.className = 'sys';
        div.appendChild(document.createTextNode(time + ' 系统消息:' + msg));
        chatWrapper.appendChild(div);
        chatWrapper.scrollTop += 100;
    }

    function updateUserList(userList){

    }


</script>

</html>