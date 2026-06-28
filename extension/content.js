const API_URL = "http://127.0.0.1:8000/api/predict-tweet";

function getTweetText(tweetElement) {
    const tweetText = tweetElement.querySelector('[data-testid="tweetText"]');
    return tweetText ? tweetText.innerText : null;
}

function getUsername(tweetElement) {
    const userText = tweetElement.querySelector('[data-testid="User-Name"]');
    return userText ? userText.innerText.split("\n")[0] : "x_user";
}

function isTelkomselOfficial(tweetElement) {
    const userNameBlock = tweetElement.querySelector('[data-testid="User-Name"]');
    if (!userNameBlock) return false;

    const text = userNameBlock.innerText.toLowerCase();

    // Skip hanya tweet dari akun resmi @Telkomsel
    return text.includes("@telkomsel");
}

function isRelatedToTelkomsel(tweetElement, text) {
    const lower = text.toLowerCase();
    const fullText = tweetElement.innerText.toLowerCase();

    return (
        lower.includes("telkomsel") ||
        lower.includes("@telkomsel") ||
        lower.includes("tsel") ||
        fullText.includes("membalas @telkomsel") ||
        fullText.includes("replying to @telkomsel") ||
        fullText.includes("@telkomsel")
    );
}

function createBadge(result) {
    const prediction = result.prediction ?? result;

    const sentiment = (prediction.sentiment ?? "-").toString().toLowerCase();

    const hate = (
        prediction.hate_speech == 1 ||
        prediction.hate_speech === "1" ||
        prediction.hate_speech === "Ya" ||
        prediction.hate_speech === "ya"
    ) ? "Ya" : "Tidak";

    const sarcasm = (
        prediction.sarcasm == 1 ||
        prediction.sarcasm === "1" ||
        prediction.sarcasm === "Ya" ||
        prediction.sarcasm === "ya"
    ) ? "Ya" : "Tidak";

    const sentimentConfidence = prediction.confidence_sentiment ?? "-";
    const hateConfidence = prediction.confidence_hate ?? "-";
    const sarcasmConfidence = prediction.confidence_sarcasm ?? "-";

    let mainLabel = "Normal";
    let mainClass = "normal";
    let mainScore = sentimentConfidence;

    if (hate === "Ya") {
        mainLabel = "Hate Speech";
        mainClass = "hate";
        mainScore = hateConfidence;
    } else if (sarcasm === "Ya") {
        mainLabel = "Sarcasm";
        mainClass = "sarcasm";
        mainScore = sarcasmConfidence;
    } else if (sentiment === "negative") {
        mainLabel = "Negatif";
        mainClass = "negative";
        mainScore = sentimentConfidence;
    }

    const badge = document.createElement("div");
    badge.className = `telko-mini-badge ${mainClass}`;

    badge.innerHTML = `
        <span class="telko-brand">TELKOSENTIMEN</span>
        <span class="telko-dot-text">•</span>
        <span class="telko-main">${mainLabel}</span>
        <span class="telko-score">${mainScore}%</span>
    `;

    return badge;
}

async function analyzeTweet(tweetElement) {
    if (tweetElement.dataset.telkomselAnalyzed === "true") return;

    if (isTelkomselOfficial(tweetElement)) {
        tweetElement.dataset.telkomselAnalyzed = "true";
        return;
    }

    const text = getTweetText(tweetElement);
    if (!text) return;

    if (!isRelatedToTelkomsel(tweetElement, text)) {
        return;
    }

    tweetElement.dataset.telkomselAnalyzed = "true";

    const tweetText = tweetElement.querySelector('[data-testid="tweetText"]');

    const loading = document.createElement("div");
    loading.className = "telkomsel-ai-loading";
    loading.innerText = "Menganalisis tweet Telkomsel...";

    if (tweetText) {
        tweetText.insertAdjacentElement("afterend", loading);
    } else {
        tweetElement.appendChild(loading);
    }

    try {
        const response = await fetch(API_URL, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify({
                text: text,
                username_x: getUsername(tweetElement)
            })
        });

        const result = await response.json();

        loading.remove();

        const badge = createBadge(result);

        if (tweetText) {
            tweetText.insertAdjacentElement("afterend", badge);
        } else {
            tweetElement.appendChild(badge);
        }

    } catch (error) {
        loading.innerText = "Gagal analisis. Pastikan Laravel & Flask aktif.";
        console.error("Telkomsel AI Error:", error);
    }
}

function scanTweets() {
    const tweets = document.querySelectorAll('article[data-testid="tweet"]');
    tweets.forEach(tweet => analyzeTweet(tweet));
}

setInterval(scanTweets, 3000);
scanTweets();