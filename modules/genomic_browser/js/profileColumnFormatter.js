function formatColumn(column, cell, rowData) {
    if (column === 'PSCID') {
        var url = loris.BaseURL + "/" + rowData[1] + "/";
        return React.createElement(
            "td",
            null,
            React.createElement(
                "a",
                { href: url },
                cell
            )
        );
    }
    return React.createElement(
        "td",
        null,
        cell
    );
}

