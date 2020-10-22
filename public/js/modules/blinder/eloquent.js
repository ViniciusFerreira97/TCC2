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
        let speakable = eloquent.stripHtml(text);
        let speaking = new SpeechSynthesisUtterance(speakable);
        speaking.lang = eloquent.lang;
        speechSynthesis.speak(speaking);
        return eloquent;
    }

    static speakText(text, delay = 500) {
        let splitedText = text.split('.');
        for (let i in splitedText) {
            setTimeout(function () {
                eloquent.speak(splitedText[i]);
            }, delay);
        }
        return eloquent;
    }

    static stripHtml(html)
    {
        var tmp = document.createElement("DIV");
        tmp.innerHTML = html;
        return tmp.textContent || tmp.innerText || "";
    }
}
