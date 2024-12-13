window.addEventListener('DOMContentLoaded', () => {
    const $ = document,
        navBtn = $.querySelector('.mobile-nav__btn'),
        mobileNavMenu = $.querySelector('.mobile-nav-menu');
    if (navBtn) {

        navBtn.addEventListener('click', () => {
            navBtn.classList.toggle('mobile-nav__btn--open')
            mobileNavMenu.classList.toggle('mobile-nav-menu--open')
        })
    }

    let wordsArray = []
    let index = 0;

    const allTitles = document.querySelectorAll('.card-title')
    allTitles.forEach(title => {
        title.addEventListener('click', (e) => {
            playSound(e.target.nextElementSibling)
        })
    })

    function playSound(audioElem) {
        if (audioElem.getAttribute('src') == '') {
            alert('No sound')
        } else {
            audioElem.play()
        }
    }
    const indexCounter = $.querySelector('#index')
    const cardWrapper = $.querySelector('#card-wrapper')

    function showCard() {
        indexCounter.classList.remove('d-none')
        cardWrapper.classList.remove('d-none')
    }

    const randomBtn = $.querySelector('#randomBtn')
    if (randomBtn) {
        randomBtn.addEventListener('click', () => {
            let url = randomBtn.dataset.url
            randomizer(url)
            showCard()
        })
    }

    const newWordsBtn = $.querySelector('#newWordsBtn')
    if (newWordsBtn) {

        newWordsBtn.addEventListener('click', () => {
            let url = newWordsBtn.dataset.url
            newWords(url)
            showCard()
        })
    }

    const oldWordsBtn = $.querySelector('#oldWordsBtn')

    if (oldWordsBtn) {
        oldWordsBtn.addEventListener('click', () => {
            leitner(oldWordsBtn.dataset.url)
            showCard()
        })
    }

    async function randomizer(url) {
        await fetch(url)
            .then(res => res.json())
            .then(data => {
                console.log(data);

                if (data.length == 0) {
                    alert('No Random Word')
                    return
                }
                wordsArray = data
                changeFlashCard()
                index = 0
                indexElem.textContent = `${index + 1} / 20`

            })

            .catch(err => console.error(err))
    }

    async function newWords(url) {
        await fetch(url)
            .then(res => res.json())
            .then(data => {

                if (data.length == 0) {
                    alert('No Word')
                    return
                }

                wordsArray = []

                data.forEach(item => {
                    wordsArray.push(item)
                })

                console.log(wordsArray);

                changeNewFlashCard()
                index = 0
                indexElem.textContent = `${index + 1} / ${wordsArray.length}`
            })

            .catch(err => console.log(err))
    }

    async function leitner(url) {
        await fetch(url)
            .then(res => res.json())
            .then(data => {

                if (data.length == 0) {
                    alert('No Word')
                    return
                }

                wordsArray = []

                data.forEach(item => {
                    item.word.answers = item.value
                    wordsArray.push(item.word)
                })

                console.log(wordsArray);

                changeFlashCard()
                index = 0
                indexElem.textContent = `${index + 1} / ${wordsArray.length}`
            })

            .catch(err => console.log(err))

    }

    const title = document.querySelector('#title')
    const audio = document.querySelector('#audio')
    const translate = document.querySelector('#translate')
    const example = document.querySelector('#example')
    const known = document.querySelector('#known')
    const learn = document.querySelector('#learn')
    const value = document.querySelector('#value')
    const indexElem = document.querySelector('#index')

    function changeFlashCard() {
        title.textContent = wordsArray[index].name

        if (wordsArray[index].audios.length > 0) {
            audio.src = wordsArray[index].audios[0]
        } else {
            audio.src = ''
        }

        translate.textContent = 'مشاهده'

        example.textContent = 'مثال'
        example.style.cssText = 'font-size:1.5rem;'

        translate.title = wordsArray[index].synonym[0]
        example.title = wordsArray[index].examples[0]
        value.textContent = wordsArray[index].answers
        known.href = `${known.dataset.url}?word_id=${wordsArray[index].id}`
        learn.href = `${learn.dataset.url}?word_id=${wordsArray[index].id}`

        known.dataset.action = 'old'
        learn.dataset.action = 'old'
    }

    translate.addEventListener('click', () => {
        translate.textContent = translate.title
    })

    example.addEventListener('click', () => {
        example.textContent = example.title
        example.style.cssText = 'font-size:1rem;'
    })

    known.addEventListener('click', (event) => {
        const isNew = known.dataset.action == 'new'
        changeIndex(event, isNew)

    })

    learn.addEventListener('click', (event) => {
        const isNew = learn.dataset.action == 'new'
        changeIndex(event, isNew)
    })

    function changeIndex(event, isNew) {
        event.preventDefault()

        if (index < wordsArray.length - 1) {
            ajaxRequest(event.target.href)
            index++
            indexElem.textContent = `${index + 1} / ${wordsArray.length}`
            if (isNew) {
                changeNewFlashCard()
            } else {
                changeFlashCard()
            }

        } else if (index >= wordsArray.length - 1) {
            ajaxRequest(event.target.href)
            disableButtons()
            alert('Today step\'s words are done')
        }
    }

    function disableButtons() {
        known.disabled = true
        learn.disabled = true
    }

    async function ajaxRequest(url) {

        await fetch(url)
            .catch(err => console.error(err))
    }

    function changeNewFlashCard() {
        title.textContent = wordsArray[index].name

        if (wordsArray[index].audios.length > 0) {
            audio.src = wordsArray[index].audios[0]
        } else {
            audio.src = ''
        }

        translate.textContent = 'مشاهده'

        example.textContent = 'مثال'
        example.style.cssText = 'font-size:1.5rem;'

        let answerValue = null
        if (wordsArray[index].answers) {

            if (wordsArray[index].answers.length > 0) {
                answerValue = wordsArray[index].answers[0].value
            } else {
                answerValue = 0
            }

        } else {
            answerValue = 0
        }

        translate.title = wordsArray[index].synonym[0]
        example.title = wordsArray[index].examples[0]
        value.textContent = answerValue
        known.href = `${known.dataset.new}?word_id=${wordsArray[index].id}`
        learn.href = `${learn.dataset.new}?word_id=${wordsArray[index].id}`

        known.dataset.action = 'new'
        learn.dataset.action = 'new'

    }

})

