$(document).ready(function () {
    let data = []; // Для зберігання даних із сервера

    // Функція для завантаження даних
    function loadData() {
        $.ajax({
            url: "fetch_data.php",
            method: "GET",
            success: function (response) {
                data = JSON.parse(response);
                renderTable(data);
            },
            error: function (xhr, status, error) {
                console.error("Error fetching data:", error);
            }
        });
    }

    // Функція для рендерингу таблиці
    function renderTable(data) {
        const tbody = $("#data-table tbody");
        tbody.empty(); // Очистити таблицю
        data.forEach(row => {
            tbody.append(`
                <tr>
                    <td>${row.id}</td>
                    <td>${row.name}</td>
                    <td>${row.email}</td>
                    <td>${row.age}</td>
                    <td>${row.Fav_subject}</td>
                    <td>${row.video_game}</td>
                    <td>${row.Working_out}</td>
                    <td>${row.dream_profession}</td>
                    <td>
                        <form method="post" action="delete.php" style="display:inline;">
                            <input type="hidden" name="id" value="${row.id}">
                            <button type="submit" name="delete">Delete</button>
                        </form>
                    </td>
                </tr>
            `);
        });
    }

    // Кнопки для сортування
    $("#sort-name").click(function () {
        const sortedData = [...data].sort((a, b) => a.name.localeCompare(b.name));
        renderTable(sortedData);
    });

    $("#sort-age").click(function () {
        const sortedData = [...data].sort((a, b) => a.age - b.age);
        renderTable(sortedData);
    });

    // Оновлення даних
    $("#refresh").click(function () {
        loadData();
    });

    // Завантажити дані при завантаженні сторінки
    loadData();
});
