module.exports = {
    apps: [
        {
            name: 'Member-api Websocket',
            exec_mode: 'cluster',
            instances: 1, // Or a number of instances
            script: 'php artisan websockets:serve',
            //args: 'start',
        },
        {
            name: 'Member-api Queue Worker',
            exec_mode: 'cluster',
            instances: 1, // Or a number of instances
            script: 'php artisan queue:work',
            //args: 'start',
        },
    ],
}
