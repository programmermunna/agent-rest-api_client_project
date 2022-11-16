module.exports = {
    apps: [
        {
            "name": "Member-api Websocket",
            "script": "artisan",
            "args": ["websockets:serve"],
            "instances": "1",
            "wait_ready": true,
            "autorestart": true,
            "max_restarts": 2,
            "interpreter" : "php",
            "watch": true,
            "time": true
        },
        {
            "name": "Member-api Queue Worker",
            "script": "artisan",
            "args": ["queue:work"],
            "instances": "1",
            "wait_ready": true,
            "autorestart": true,
            "max_restarts": 2,
            "interpreter" : "php",
            "watch": true,
            "time": true
        },
    ],
}
