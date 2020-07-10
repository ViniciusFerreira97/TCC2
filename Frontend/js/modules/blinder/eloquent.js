export default class eloquent {

    static lang = 'pt-BR';
    static listenning = false;
    static listenningHistoric = [];

    static loadRecognition() {
        var SpeechRecognition = SpeechRecognition || webkitSpeechRecognition;
        return new SpeechRecognition();
    }

    static startListenning() {
        eloquent.recognition = eloquent.loadRecognition();
        eloquent.recognition.lang = eloquent.lang;
        eloquent.recognition.interimResults = false;
        eloquent.recognition.continuous = false;
        eloquent.recognition.maxAlternatives = 1;
        eloquent.recognition.start();
        eloquent.listenning = true;
        return eloquent;
    }

    static stopListenning(callback) {
        eloquent.recognition.stop();
        eloquent.listenning = false;
        eloquent.callback = callback;

        if (eloquent.callback != undefined) {
            eloquent.recognition.onresult = function (event) {
                let text = event.results[0][0].transcript;
                eloquent.listenningHistoric.push(text);
                eloquent.callback(text, event);
            };
        }
        return eloquent;
    }

    static speak(text) {
        let speaking = new SpeechSynthesisUtterance(text);
        speaking.lang = eloquent.lang;
        speechSynthesis.speak(speaking);
        return eloquent;
    }

    static speakText(text) {
        let splitedText = text.split('.');
        for (let i in splitedText) {
            setTimeout(function () {
                eloquent.speak(splitedText[i]);
            }, 500);
        }
        return eloquent;
    }
}