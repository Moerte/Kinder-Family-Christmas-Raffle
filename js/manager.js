$(document).ready(() =>{
    $('.startQuest').click(() => {
        initializeQuestionary();
    });
    $('.startQuest_2').click(() =>{
        initializeQuestionary();
    });
});

function initialPage() {
    $(".main").addClass("all-height");
    $("#form_container").removeClass("d-none");
    $(".main").removeClass("half-height");
    $(".main").removeClass("fixed-top");
    $(".sorteio").removeClass("d-none");
    $(".heading-primary-sub").removeClass("d-none");
    $("#initial_text").addClass("d-none");
    $("#finish_text").removeClass("d-none");
}

function initializeQuestionary() {
    $(".main").removeClass("all-height");
    $("#form_container").removeClass("d-none");
    $(".main").addClass("half-height");
    $(".main").addClass("fixed-top");
    $(".startQuest").addClass("d-none");
    $(".sorteio").addClass("d-none");
    $(".heading-primary-sub").addClass("d-none");
}
