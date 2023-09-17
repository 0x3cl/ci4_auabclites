
import {
        site_overview,
        site_visitor_graph,
        site_referrer_graph,
} from "./components/graph.js";

$(document).ready(function() {
    
    // SITE GRAPHS

    if(window.location.pathname === '/auabclites/admin/dashboard') {
        site_overview();
        site_visitor_graph();
        site_referrer_graph();
    }
});