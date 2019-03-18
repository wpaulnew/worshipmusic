let href = location.origin;

$(".walkman").hide();

const audio = document.createElement("audio");
audio.src = '';
audio.volume = 0.1;
audio.autoPlay = false;
audio.preLoad = true;
audio.controls = false;

// Все что меняется можно записать здесь
let store = {
  "tracks": {},
  "initialload": false,
  "foundtracks": {},
  "currenttrack": "", // Текущий выбранный трек
  "nxttrack": "", // Следующий трек
  "bcktrack": "", // Предыдущий трек
  "paused": false, // Поменяэм потом
  "findstring": "",
  "finaltrackid": ''
};

setTimeout(function () {
  // Получаею список первоначальных треков, для дальнейшей работы
  if (store.initialload == false) {
    $.post(href + "/informations")
      .done(function (answer) {
        store.tracks = JSON.parse(answer);

        store.initialload = true;

        // Получаем id последней песни в миссиве песен
        store.finaltrackid = store.tracks[store.tracks.length - 1].id;

        console.log(store);
      });
  }
}, 100);

// Включаем песню по нажатию на элемент
$(".audio-container").on("click", ".audio-active-place", function () {

  let id = $(this).attr("data-id");

  $.post(href + "/information", {trackId: id})
    .done(function (answer) {

      store.currenttrack = JSON.parse(answer);

      $(".title").text(store.currenttrack.title);
      $(".author").text(store.currenttrack.executor);
      $(".btns-open-viewer").attr("data-id", store.currenttrack.id);

      audio.src = "http://fonki.pro/plugin/sounds/uploads/" + store.currenttrack.ref + ".mp3";
      audio.play();

      store.nxttrack = store.tracks.filter(e => e.id == parseInt(store.currenttrack.id) + 1)[0];
      store.bcktrack = store.tracks.filter(e => e.id == parseInt(store.currenttrack.id) - 1)[0];

      // store.nxttrack = store.initialtracks[store.currenttrack.id - 1];

      $(".walkman").show();


      console.log("on", store);

    });

});

// Загружаем файл
$(".btns-download-track").on("click", function () {
  event.preventDefault();

  $.post(href + "/download", {id: store.currenttrack.id})
    .done(function (answer) {
      console.log(answer);

      // let file = JSON.parse(answer).file;
      //
      // let link = document.createElement('a');
      //
      // link.href = href + "/public/media/" + file;
      // link.download = container.track.executor + " — " + container.track.title;
      // document.body.appendChild(link);
      // link.click();
      // document.body.removeChild(link);
    });
});

// Обратчик играть/остановить по главной кнопке
$("#track-continue").on("click", function () {
  $(this).hide(0, function () {
    audio.play();
    $("#track-pause").show();
  });
});
$("#track-pause").on("click", function () {
  $(this).hide(0, function () {
    audio.pause();
    $("#track-continue").show();
  });
});

// Обновляем timeline, показываем сколько времени прошло и добавляем возможность перемотки
$("#timeline").on("input", function () {
  audio.currentTime = $(this).val();
});
audio.addEventListener("timeupdate", function () {
  $("#timeline").val(audio.currentTime);
});
audio.addEventListener("loadedmetadata", function () {
  $("#timeline").attr("step", audio.duration / 100);
  $("#timeline").attr("max", audio.duration);
});

// Включаем следующий трек в списке
audio.onended = function () {
  store.currenttrack = store.nxttrack;

  $(".title").text(store.currenttrack.title);
  $(".author").text(store.currenttrack.executor);
  $(".btns-open-viewer").attr("data-id", store.currenttrack.id);

  audio.src = "http://fonki.pro/plugin/sounds/uploads/" + store.currenttrack.ref + ".mp3";
  audio.play();

  store.nxttrack = store.tracks.filter(e => e.id == parseInt(store.currenttrack.id) + 1)[0];
  store.bcktrack = store.tracks.filter(e => e.id == parseInt(store.currenttrack.id) - 1)[0];

  console.log(store);
};

let viewopen = false;
// По клику откывается/закрыватся просотр слов
$(".btns-open-viewer").on("click", function () {

  const trackId = $(this).attr("data-id");
  viewopen = !viewopen;

  $("body").css("overflow", open ? "hidden" : "scroll");

  if (viewopen == true) {

    $(this).addClass("cc");


    $(".viewer").show(0, function () {
      $(this).addClass("up");
      $(".viewer").scrollTop(0);
      $(".viewer-text").html(store.currenttrack.words);
      $(".d-canvas").show(0, function () {
        $(".walkman").addClass("viewer-on");
      });
      $(".viewer-text > b").removeAttr("style");
    });
  }

  if (viewopen == false) {
    $(this).removeClass("cc");

    $(".walkman").removeClass("viewer-on");
    $(".viewer").hide();

    $(".d-canvas").hide();
    $("body").css("overflow", "scroll");
  }

});

//Закрываем плеер
$(".btn-close-walkman").on("click", function () {
  $(".d-canvas").hide();
  $(".walkman").removeClass("viewer-on");
  $(".btns-open-viewer").removeClass("cc");
  $(".walkman").removeClass("up").addClass("down");
  setTimeout(function () {
    $(".walkman").hide();
    $(".walkman").removeClass("down").addClass("up");
  }, 1000);
  $("body").css("overflow", "scroll");

  $(".viewer").hide();

  audio.src = '';
  audio.currentTime = 0;
  audio.pause();
});

// Подгружаем песни
$("#load-more").on("click", function () {
  // console.log(store.finaltrackid);
  $.post(href + "/load", {finalid: store.finaltrackid})
    .done(function (answer) {
      // console.log(answer);
      let ts = JSON.parse(answer);

      // Соеденяем масивы
      Array.prototype.push.apply(store.tracks, ts);

      // Обновляем id последней песни в миссиве песен
      store.finaltrackid = store.tracks[store.tracks.length - 1].id;

      console.log(store);

      $.each(ts, function (index, t) {
        let html = `
        <div class="audio up">
          <div class="audio-components">
            <div class="audio-active-place" data-id="${t.id}">
              <div class="audio-condition-off">
                <img src="http://fonki.pro/plugin/sounds/img_albums/${t.icon}" alt="${t.executor}" class="audio-icon"/>
                <div class="audio-description">
                  <span class="audio-name">${t.title}</span>
                  <span class="audio-author">${t.executor}</span>
                </div>
              </div>
            </div>
            <div class="audio-control-buttons">
              <button class="audio-btn-download"></button>
              <button class="audio-btn-download-background"></button>
            </div>
          </div>
        </div>
      `;

        setTimeout(function () {
          $(".audio-container").append(html)
        }, 100);
      });
    });
});

// Поиск
$("#input-find").on("keyup", function () {

    let findstring = $(this).val();

    store.findstring = findstring;

    if (findstring <= 0) {
      // console.log(answer);
      let ts = store.tracks;

      let html = '';
      $.each(ts, function (index, t) {
        html += `
        <div class="audio">
          <div class="audio-components">
            <div class="audio-active-place" data-id="${t.id}">
              <div class="audio-condition-off">
                <img src="http://fonki.pro/plugin/sounds/img_albums/${t.icon}" alt="${t.executor}" class="audio-icon"/>
                <div class="audio-description">
                  <span class="audio-name">${t.title}</span>
                  <span class="audio-author">${t.executor}</span>
                </div>
              </div>
            </div>
            <div class="audio-control-buttons">
              <button class="audio-btn-download"></button>
              <button class="audio-btn-download-background"></button>
            </div>
          </div>
        </div>
      `;

        $(".audio-container").html(html);

        $("#what-we-do").text("всего");
        $("#find-count-found").text("6,371");

        $(".btn-load-more").show();
      });
    }

    // Надо проверять что -- делаем запрос еще раз если значение изменилось
    if (findstring.length >= 1) {

      setTimeout(function () {
        $.post(href + "/find", {findString: findstring})
          .done(function (answer) {

            let audios = JSON.parse(answer);

            let count = audios.length;

            $("#what-we-do").text("найдено");
            $("#find-count-found").text(count);

            if (audios.condition == false) {
              console.log(audios);

              $("#what-we-do").text("найдено");
              $("#find-count-found").text("0");

              $(".btn-load-more").hide();
              $(".audio-container").html('');
              return false;
            }

            let html = '';

            $.each(audios, function (index, t) {
              html += `
            <div class="audio">
              <div class="audio-components">
                <div class="audio-active-place" data-id="${t.id}">
                  <div class="audio-condition-off">
                    <img src="http://fonki.pro/plugin/sounds/img_albums/${t.icon}" alt="${t.executor}" class="audio-icon"/>
                    <div class="audio-description">
                      <span class="audio-name">${t.title}</span>
                      <span class="audio-author">${t.executor}</span>
                    </div>
                  </div>
                </div>
                <div class="audio-control-buttons">
                  <button class="audio-btn-download"></button>
                  <button class="audio-btn-download-background"></button>
                </div>
              </div>
            </div>
            `;
            });

            $(".audio-container").html(html);
          });
      }, 100);
    }
  }
);
