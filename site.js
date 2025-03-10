async function calculateIP() {
    let ip = document.getElementById("ipAddress").value.trim();
    let subnet = document.getElementById("subnet").value.trim();
    let resultDiv = document.getElementById("ipCalcResult");

    if (!ip || !subnet) {
        resultDiv.innerHTML = "<div class='alert alert-danger'>لطفاً آدرس IP و Subnet Mask یا CIDR را وارد کنید!</div>";
        return;
    }

    try {
        let response = await fetch('ip_calculator.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'ip=' + encodeURIComponent(ip) + '&subnet=' + encodeURIComponent(subnet)
        });

        // چاپ محتوای پاسخ برای بررسی
        let textResponse = await response.text();
        console.log('Response:', textResponse);  // برای مشاهده محتوای پاسخ

        if (!response.ok) {
            throw new Error(`خطای سرور: ${response.status}`);
        }

        // بررسی آیا پاسخ JSON است؟
        let data = JSON.parse(textResponse);  // تبدیل به JSON
        let resultHTML = '<table style="width: 100%; border-collapse: collapse; border: 1px solid #ddd;">';
        resultHTML += '<thead><tr><th style="padding: 8px; text-align: right; background-color: #f2f2f2;">فیلد</th><th style="padding: 8px; text-align: right; background-color: #f2f2f2;">مقدار</th></tr></thead>';
        resultHTML += '<tbody>';

        for (let key in data) {
            resultHTML += `<tr>
                            <td style="padding: 8px; border: 1px solid #ddd; background-color: #fafafa; font-weight: bold;">${key}</td>
                            <td style="padding: 8px; border: 1px solid #ddd; background-color: #fafafa;">${data[key]}</td>
                        </tr>`;
        }

        resultHTML += '</tbody></table>';

        // نمایش داده‌ها در UI
        resultDiv.innerHTML = resultHTML;
    } catch (error) {
        console.error('Error:', error);
        resultDiv.innerHTML = "<div class='alert alert-danger'>خطایی رخ داده است، لطفاً دوباره تلاش کنید.</div>";
    }
}
