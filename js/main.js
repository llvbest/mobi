(function ($) {
    "use strict";

    const DA_SORT_LINK = 'sort-link';
    const DA_FILTER_FORM = 'filter-form';
    const DA_TOGGLE_TRIGGER = 'toggle-trigger';
    const DA_TOGGLE_TARGET = 'toggle-target';
    const DA_DELETE_ALBUM = 'delete-album';

    /**
     * Returns key-value object of query params
     * @returns {{}}
     */
    function getQueryParams(queryString) {
        let queryParams = {};

        // Parse given query string or current page's query string
        queryString = queryString || location.search.substr(1);

        queryString.split("&").forEach(function (pair) {
            if (pair === "") return;
            let parts = pair.split("=");
            queryParams[parts[0]] = parts[1] &&
                decodeURIComponent(parts[1].replace(/\+/g, " "));
        });
        return queryParams;
    }

    function setQueryParams(params) {
        let pairs = [];
        for (let name in params) {
            if (params.hasOwnProperty(name)) {
                pairs.push(`${name}=${params[name]}`);
            }
        }
        location.href = pairs.length ? 'index.php?' + pairs.join('&') : '?';
    }

    const Collection = {
        orderBy: null,
        filter: {},
        init() {
            this.bindHandlers();
        },
        bindHandlers() {
            $(document).on('click', `[data-${DA_SORT_LINK}]`, e => {
                let sortBy = $(e.target).attr('href');
                this.applySort(sortBy);
                return false;
            });

            // Click on trigger (show/hide target element)
            $(document).on('click', `[data-${DA_TOGGLE_TRIGGER}]`, e => {
                let target = $(e.target).data(DA_TOGGLE_TRIGGER);

                $(document).find(`[data-${DA_TOGGLE_TARGET}]`).each((ind, elm) => {
                    let name = $(elm).data(DA_TOGGLE_TARGET);
                    return name === target ? $(elm).toggle() : $(elm).hide();
                });
            });

            // Apply filters
            $(document).on('submit', `[data-${DA_FILTER_FORM}]`, e => {
                this.applyFilters($(e.target).serialize());
                return false;
            });

            // Delete album on click
            $(document).on('click', `[data-${DA_DELETE_ALBUM}]`, e => {
                let albumId = $(e.target).data(DA_DELETE_ALBUM);

                if (!albumId || !confirm('Удалить?')) return;

                this.deleteAlbum(albumId, () => {
                    location.reload();
                });
            });
        },
        deleteAlbum(id, cb) {
            $.get('/index.php?controller=index&action=delete', {id}, response => {
                if (response.status) {
                    if (typeof cb === 'function') cb();
                }
            }, 'json');
        },
        applySort(colName) {
            let params = getQueryParams();
            params['sort'] = colName;
            setQueryParams(params);
        },
        applyFilters(queryStr) {
            let currentQuery = getQueryParams();
            let formQuery = getQueryParams(queryStr);

            for (let name in formQuery) {
                if (formQuery.hasOwnProperty(name)) {
                    currentQuery[name] = formQuery[name];
                }
            }

            // Filter out empty params
            for (let name in currentQuery) {
                if (currentQuery.hasOwnProperty(name)) {
                    if (!currentQuery[name].length) {
                        delete currentQuery[name];
                    }
                }
            }

            setQueryParams(currentQuery);
        },
    };

    // DOM Loaded
    $(function () {
        Collection.init();
    });

})(jQuery);