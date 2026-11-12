console.log("oi..");

// const response = await fetch("http://localhost/api/faqs/faqs-categories/");
// console.log(response);

async function fetchFAQs() {
    const response = await fetch("http://localhost/fazendinhaNOVA/api/faqs/category/1");

    console.log(response);

    const faqs = await response.json();

    console.log(faqs.data);

    const listFaqs = document.querySelector("#list-faqs");

    faqs.data.forEach(faq => {
        console.log(faq.answer, faq.question);

        const faqItem = document.createElement("div");

        faqItem.innerHTML = `
            <dt>
                    <span>${faq.question}</span>
                    <i data-lucide="plus" class="w-5 h-5 faq-icon text-surface-gray" aria-hidden="true"></i>
            </dt>

            <dd class="faq-answer">
                <p>${faq.answer} <br> </p>
            </dd>
        `;

        listFaqs.appendChild(faqItem);
    });
}

function initFAQ() {
    const listFaqs = document.querySelector("#list-faqs");

    if (!listFaqs) return;

    fetchFAQs();
}

initFAQ();