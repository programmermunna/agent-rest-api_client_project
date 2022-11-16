module.exports = {
    apps: [
        {
            name: 'Member-api Websocket',
            exec_mode: 'cluster',
            instances: 1, // Or a number of instances
            script: 'php artisan websockets:serve --host=https://member-api.cktch.top',
            //args: 'start',
        },
        {
            name: 'Member-api Queue Listener',
            exec_mode: 'cluster',
            instances: 1, // Or a number of instances
            script: 'php artisan queue:listen',
            //args: 'start',
        },
    ],
}
