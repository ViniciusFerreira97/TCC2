<html>
<head>
  <base href="/">
  <title>Watson Assistant Chat App</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta property="og:image" content="conversation.svg" />
  <meta property="og:title" content="Conversation Chat Simple" />
  <meta property="og:description" content="Sample application that shows how to use the Watson Assistant API to identify user intents" />
</head>

<body>
    <h3>Clique e fale: <button id="btnSayIt" onclick="fnSayIt('Clique e fale');">Ouvir</button></h3>
    <div>
        <button id="btnStart">Gravar</button>
        <button id="btnStop">Parar</button>
    </div>
    <div class="clear:both"></div>
    <div id="divText"></div>

    <script type="text/javascript">
        var voices = speechSynthesis.getVoices();
        console.log(voices);


        for(i = 0; i < voices.length ; i++) {
            var option = document.createElement('option');
            option.textContent = voices[i].name + ' (' + voices[i].lang + ')';
            option.setAttribute('data-lang', voices[i].lang);
            option.setAttribute('data-name', voices[i].name);
            voiceSelect.appendChild(option);
        }

        function fnSayIt(textToSay){
            var utterThis = new SpeechSynthesisUtterance('Ahh eu vou gozar!');
            speechSynthesis.speak(utterThis);
        }
    </script>
    <script type="text/javascript">
        //var grammar = '#JSGF V1.0; grammar colors; public <color> = aqua | azure | beige | bisque | black | blue | brown | chocolate | coral | crimson | cyan | fuchsia | ghostwhite | gold | goldenrod | gray | green | indigo | ivory | khaki | lavender | lime | linen | magenta | maroon | moccasin | navy | olive | orange | orchid | peru | pink | plum | purple | red | salmon | sienna | silver | snow | tan | teal | thistle | tomato | turquoise | violet | white | yellow ;'
        
        var SpeechRecognition = SpeechRecognition || webkitSpeechRecognition
        var SpeechGrammarList = SpeechGrammarList || webkitSpeechGrammarList
        var SpeechRecognitionEvent = SpeechRecognitionEvent || webkitSpeechRecognitionEvent

        var recognition = new SpeechRecognition();
        //var speechRecognitionList = new SpeechGrammarList();
        //speechRecognitionList.addFromString(grammar, 1);
        //recognition.grammars = speechRecognitionList;

        recognition.lang = 'pt-BR';
        recognition.interimResults = true;
        recognition.continuous = true;
        recognition.maxAlternatives = 1;

        var diagnostic = document.querySelector('.output');
        var bg = document.querySelector('html');
        var outputObject = document.getElementById('divText');

        document.getElementById('btnStart').onclick = function() {
            recognition.start();
        }

        document.getElementById('btnStop').onclick = function() {
            recognition.stop();
            //recognition.continuous = false;
        }

        // document.body.onclick = function() {
        //     recognition.start();
        //     console.log('Ready to receive a color command.');
        // }

        recognition.onresult = function(event) {
            console.log('event.results', event.results);
            var transcriptedText = event.results[0][0].transcript;
            outputObject.innerHTML += transcriptedText  + '<br />';
            
            // var color = event.results[0][0].transcript;
            // diagnostic.textContent = 'Result received: ' + color;
            // bg.style.backgroundColor = color;
        }
    </script>
</body>

</html>