$(document).ready(() => {
    OPENVIDU_SERVER_URL = 'https://conf.codecycler.com';

    var OV;
    var session;

    //
    var component = document.getElementById('ov-stream-publisher');
    var token = component.getAttribute('data-token');

    //
    OV = new OpenVidu();
    session = OV.initSession();

    //
    session.on('streamCreated', function (event) {
        console.log('Nieuwe deelnemer');
        console.log(event);
        var subscriber = session.subscribe(event.stream, 'subscriber');

        subscriber.createVideoElement(document.getElementById('ov-stream-subscriber'), 'APPEND');
    });

    //
    session.connect(token)
        .then(() => {
            var publisher = OV.initPublisher("publisher");
            session.publish(publisher);

            publisher.addVideoElement(document.getElementById('ov-stream-publisher'), 'APPEND');
        })
        .catch(error => {
            console.log("There was an error connecting to the session:", error.code, error.message);
        });
});
