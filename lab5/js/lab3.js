$(document).ready(function() {
    const redukcjaRuchu = window.matchMedia('(prefers-reduced-motion: reduce)');

    function ustawRuch() {
        $.fx.off = redukcjaRuchu.matches;
    }

    ustawRuch();
    redukcjaRuchu.addEventListener('change', ustawRuch);


    const $btn1 = $('#button1-demo');
    const $btn2 = $('#button2-demo');
    const $btn3 = $('#button3-demo');
    const $resetBtn = $('#button-reset-demo')
    const $serverBtn = $('#serwer-button')
    const defaultRozmiar = { width: 160, height: 90 };
    const largeRozmiar = { width: 240, height: 130 };
    const fokusRozmiar = { width: 220, height: 120 };

    let powiekszony = false;

    $btn1.on('click', function() {
        powiekszony = !powiekszony;
        $btn1.attr('aria-pressed', powiekszony);
        $btn1.stop(true, false).animate(powiekszony ? largeRozmiar : defaultRozmiar, 300);
    });

    let maKursor = false;
    let maFokus = false;

    function fokusZmiana() {
        const zmiana = (maKursor || maFokus) ? fokusRozmiar : defaultRozmiar;
        $btn2.stop(true, false).animate(zmiana, 300);
    }

    $btn2
        .on('mouseenter', function() {
            maKursor = true;
            fokusZmiana();
        })
        .on('mouseleave', function() {
            maKursor = false;
            fokusZmiana();
        })
        .on('focus', function() {
            maFokus = $btn2.is(':focus-visible');
            fokusZmiana();
        })
        .on('blur', function() {
            maFokus = false;
            fokusZmiana();
        });

    let ileClick = 0;
    let wide = 160;
    let high = 90;
    const $statusBtn = $('#status-przycisku');
    const $statusSerwer = $('#status-serwera');

    function zwiekszRozmiar() {
        if ($btn3.is(':animated')) return;
        if (ileClick >= 5) return;
        ileClick += 1;
        $btn3.animate({ width: wide + 20 * ileClick, height: high + 10 * ileClick }, 300)
        aktualizujStatus()
    };

    function aktualizujStatus() {
        $statusBtn.text(`Guzik C wciśnięto: ${ileClick} na 5 razy`);
    };


    $btn3.on('click', zwiekszRozmiar);
    aktualizujStatus();

    $resetBtn.on('click', function() {
        $btn1.stop(true, false).css(defaultRozmiar);
        powiekszony = false;
        $btn1.attr('aria-pressed', 'false');

        $btn3.stop(true, false).css(defaultRozmiar);
        ileClick = 0;
        aktualizujStatus();
    });


    $serverBtn.on('click', function(event) {
        event.preventDefault();
        $serverBtn.attr('disabled', 'disabled');

        $statusSerwer.text('Oczekiwanie na odpowiedź serwera...')
        const serwerRequest = $.ajax({
            url: 'status.php',
            method: 'GET',
            dataType: 'text',
            timeout: 5000
        });
        serwerRequest.done(function(odpowiedz) {
            $statusSerwer.text(odpowiedz);
        });
        serwerRequest.fail(function() {
            $statusSerwer.text("Nie udało się połączyć z serwerem");
        });
        serwerRequest.always(function() {
            $serverBtn.removeAttr('disabled');
        });

    });


});