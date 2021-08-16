<?php

$pathInfo = $_SERVER['PATH_INFO'] ?? '/';

?>

<nav class="navbar navbar-expand-lg navbar-light bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">FS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/advice/10">advice calculator</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/silver/1">silver embro</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/manos/16">manos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/horse/1">horse gear</a>
                </li>
                <li class="nav item">
                    <a href="/gather" class="nav-link">gathering result</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
