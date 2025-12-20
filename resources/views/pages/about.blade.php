@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card mb-5 shadow">
                <div class="card-body">
                    <h1 class="card-title mb-4 text-center display-4 fw-bold">About Konnekt!</h1>
                    <p class="fs-5">
                        Konnekt aims to create a centralized and trustworthy web platform that enhances the connection between job seekers and employers, ensuring a simple, efficient, and transparent recruitment process.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card mb-5 shadow">
                <div class="card-body">
                    <h2 class="card-title mb-4">Our Mission</h2>
                    <p class="fs-5">
                        Konnekt is an information system with a web interface for publishing and applying to jobs. The main goal of the project is to simplify job hunting, providing both candidates and employers with a centralized, reliable, and easy-to-use platform.
                    </p>
                    <p class="fs-5">
                        This environment allows job seekers to search and apply for job opportunities, while employers can create and manage job opportunities. Administrators ensure that the system remains fair and trustworthy by supervising content and user activity.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-body text-center">
                    <h3 class="card-title mb-4">The Team</h3>
                    <ul class="list-unstyled fs-5">
                        <li class="mb-2">Daniela Azevedo -> Developer</li>
                        <li class="mb-2">Diogo Ribeiro -> Developer</li>
                        <li class="mb-2">Leonardo Carvalho -> Developer</li>
                        <li>Vasco Vieira -> Developer</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
