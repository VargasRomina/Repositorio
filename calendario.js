// Código de calendario simple
const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
let currentDate = new Date();

function renderCalendar() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    const firstDay = new Date(year, month, 1).getDay();
    const lastDate = new Date(year, month + 1, 0).getDate();

    document.getElementById("monthYear").textContent = `${monthNames[month]} ${year}`;

    const calendarTable = document.getElementById("calendarTable").getElementsByTagName("tbody")[0];
    calendarTable.innerHTML = "";

    let date = 1;
    for (let i = 0; i < 6; i++) {
        const row = calendarTable.insertRow();
        for (let j = 0; j < 7; j++) {
            if (i === 0 && j < firstDay) {
                row.insertCell();
            } else if (date > lastDate) {
                break;
            } else {
                const cell = row.insertCell();
                cell.textContent = date;
                cell.onclick = () => {
                    document.querySelectorAll("td").forEach(td => td.classList.remove("active"));
                    cell.classList.add("active");
                };
                date++;
            }
        }
    }
}

function moveMonth(direction) {
    currentDate.setMonth(currentDate.getMonth() + direction);
    renderCalendar();
}

renderCalendar();