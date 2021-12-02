$(document).ready(() => {
    OPENVIDU_SERVER_URL = 'https://conf.codecycler.com';

    var OV;
    var session;

    //
    var component = document.getElementById('ov-stream-publisher');
    var token = component.getAttribute('data-token');

    // Check is permissions are granted
    navigator.mediaDevices.getUserMedia({ audio: true, video: true})
        .then(function(stream) {
            setupOVSession();
        })
        .catch(function(err) {
            document.getElementById('ov-error-message').innerHTML = err.message;
        });

    function setupOVSession() {
        //
        OV = new OpenVidu();
        session = OV.initSession();

        //
        session.on('streamCreated', function (event) {
            var subscriber = session.subscribe(event.stream, 'subscriber');

            subscriber.createVideoElement(document.getElementById('ov-stream-subscriber'), 'APPEND');
            document.getElementById('ov-stream-subscriber-wrapper').classList.remove('hidden');
        });

        //
        session.connect(token)
            .then(() => {
                var publisher = OV.initPublisher("publisher");
                session.publish(publisher);

                publisher.addVideoElement(document.getElementById('ov-stream-publisher'), 'APPEND');
                document.getElementById('ov-stream-publisher-wrapper').classList.remove('hidden');
            })
            .catch(error => {
                console.log("There was an error connecting to the session:", error.code, error.message);
            });
    }
});
