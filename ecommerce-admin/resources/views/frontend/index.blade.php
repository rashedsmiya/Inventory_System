@extends('layouts.frontend.app')

@section('title', 'Edit User')

@section('content')



    <section class="py-5 bg-light">
        <div class="container">
            <!-- Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="header-title">Revenue Dashboard</h2>
                </div>
            </div>

            <!-- Top Stats Row -->
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-label">Active Deals</div>
                        <div class="stat-number">874</div>
                        <div class="trend-up"><i class="bi bi-arrow-up-right"></i> +20% <span class="text-muted">From last
                                month</span></div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="stat-card success">
                        <div class="stat-label">Revenue Total</div>
                        <div class="stat-number">$120,369</div>
                        <div class="trend-up"><i class="bi bi-arrow-up-right"></i> +9.0% <span class="text-muted">From last
                                month</span></div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-label">Closed Deals</div>
                        <div class="stat-number">$234,210</div>
                        <div class="trend-down"><i class="bi bi-arrow-down-right"></i> -4.5% <span class="text-muted">From
                                last month</span></div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="stat-card warning">
                        <div class="stat-label">Estimated Revenue</div>
                        <div class="stat-number">$212,142</div>
                        <div class="trend-up"><i class="bi bi-arrow-up-right"></i> +23.2%</div>
                    </div>
                </div>
            </div>

            <!-- Second Row - Charts and Progress -->
            <div class="row">
                <!-- Left Column - Statistics and Goals -->
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="chart-container">
                                <h5 class="chart-title">Monthly Statistics</h5>
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="badge-custom">Monthly</span>
                                    <span class="badge-custom">Quarterly</span>
                                    <span class="badge-custom">Annually</span>
                                </div>
                                <p class="text-muted small">Target you've set for each month</p>
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <div>
                                        <h4>$30,321.23</h4>
                                        <p class="text-muted small mb-0">Avg. Yearly Profit</p>
                                    </div>
                                    <div class="trend-up">
                                        <i class="bi bi-arrow-up-right"></i> +12.5%
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="chart-container">
                                <h5 class="chart-title">June Goals Progress</h5>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Marketing</span>
                                    <span class="fw-bold">85%</span>
                                </div>
                                <div class="progress goal-progress mb-4">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 85%"></div>
                                </div>

                                <div class="d-flex justify-content-between mb-2">
                                    <span>Sales</span>
                                    <span class="fw-bold">55%</span>
                                </div>
                                <div class="progress goal-progress mb-4">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 55%"></div>
                                </div>

                                <div class="d-flex justify-content-between mb-2">
                                    <span>Target</span>
                                    <span class="fw-bold">250</span>
                                </div>
                                <div class="progress goal-progress">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 70%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sales Category Section -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="chart-container">
                                <h5 class="chart-title">Sales Category Breakdown</h5>
                                <div class="sales-category">
                                    <div class="d-flex justify-content-between">
                                        <span>Direct Buy</span>
                                        <span class="fw-bold">33% (1,402 Products)</span>
                                    </div>
                                    <div class="category-bar">
                                        <div class="category-fill bg-primary" style="width: 33%"></div>
                                    </div>
                                </div>

                                <div class="sales-category">
                                    <div class="d-flex justify-content-between">
                                        <span>Adsense</span>
                                        <span class="fw-bold">19% (510 Products)</span>
                                    </div>
                                    <div class="category-bar">
                                        <div class="category-fill bg-success" style="width: 19%"></div>
                                    </div>
                                </div>

                                <div class="sales-category">
                                    <div class="d-flex justify-content-between">
                                        <span>Affiliate Program</span>
                                        <span class="fw-bold">48% (2,450 Products)</span>
                                    </div>
                                    <div class="category-bar">
                                        <div class="category-fill bg-warning" style="width: 48%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Upcoming Schedule -->
                <div class="col-lg-4">
                    <div class="schedule-card">
                        <h5 class="chart-title mb-4">Upcoming Schedule</h5>

                        <div class="schedule-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="schedule-time">Wed, 11 Jan • 09:20 AM</div>
                                    <div class="schedule-title">Business Analytics Press</div>
                                    <div class="schedule-desc">Exploring the Future of Data-Driven +6 more</div>
                                </div>
                                <span class="badge bg-primary">Total</span>
                            </div>
                        </div>

                        <div class="schedule-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="schedule-time">Fri, 15 Feb • 10:35 AM</div>
                                    <div class="schedule-title">Business Sprint</div>
                                    <div class="schedule-desc">Techniques from Business Sprint +2 more</div>
                                </div>
                                <span class="badge bg-success">Direct Buy</span>
                            </div>
                        </div>

                        <div class="schedule-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="schedule-time">Thu, 18 Mar • 01:15 AM</div>
                                    <div class="schedule-title">Customer Review Meeting</div>
                                    <div class="schedule-desc">Insights from the Customer Review Meeting +8 more</div>
                                </div>
                                <span class="badge bg-warning">Adsense</span>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button class="btn btn-outline-primary w-100">
                                <i class="bi bi-calendar-plus me-2"></i> Add New Schedule
                            </button>
                        </div>
                    </div>

                    <!-- Marketing & Sales Progress -->
                    <div class="chart-container mt-4">
                        <h5 class="chart-title">Marketing & Sales Progress</h5>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h4>$30,569.00</h4>
                                <p class="text-muted small mb-0">Marketing</p>
                            </div>
                            <div class="trend-up">
                                <i class="bi bi-arrow-up-right"></i> 85%
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4>$20,486.00</h4>
                                <p class="text-muted small mb-0">Sales</p>
                            </div>
                            <div class="trend-down">
                                <i class="bi bi-arrow-down-right"></i> 55%
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Note -->
            <div class="row mt-5">
                <div class="col-12 text-center text-muted">
                    <p>Dashboard updated in real-time • Last refresh: Today, 10:42 AM</p>
                </div>
            </div>
        </div>



    </section>


@endsection
