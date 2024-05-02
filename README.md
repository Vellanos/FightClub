# FightClub Symfony

## How to Simulate Matches and Bets

Before we begin, please note that no page redirection/reload is implemented in the simulations of matches and bets. Consequently, front-end information will not be dynamically updated without at least a user action or a manual page reload.

To simulate matches and bets, you need to use the following command:

```bash
php bin/console messenger:consume
```

Select option 2: scheduler_Simulation.
This allows consuming Symfony messages and activating the simulation scheduler.
A simulation is carried out every 30 seconds (modifiable in the file src/Scheduler/SimScheduleProvider.php).
To stop the simulations, stop the messenger:consume in the terminal.

Some useful commands to set up the scheduler (for informational purposes):

```bash
php bin/console make:message
composer require symfony/scheduler
```

Link to the scheduler documentation: [Symfony Scheduler Documentation](https://symfony.com/doc/current/scheduler.html)


## Project Context

Welcome to the final phase of the PHP arc! After developing your own MVC projects in PHP and exploring the Symfony framework, it's now time to showcase your skills by fully leveraging this framework.

You will utilize the skills you've acquired so far to create a modern website with sleek design and responsiveness. You are free to draw inspiration from existing websites, but be sure not to copy them.

The goal is to hone not only your technical skills but also your design and organizational skills. You will be completely autonomous from start to finish of the project, but here are some ideas to inspire you:

- Online betting site (football, rocket league, paper airplane throwing, etc.).
- Online auction site (eBay, VOGGT, StockX, etc.).
- E-commerce site.

Regardless of the chosen topic, here are the minimum expected features. You are free to add other features specific to the business sector of your project.

## Pedagogical Modalities

You have 10 half-days to complete this project, to be submitted by 05/14/2024. Solo work.

## Evaluation Modalities

Your evaluation will include an individual presentation, including an oral presentation without presentation support.

## Deliverables

- Conceptual Data Model (CDM) of the database.
- Mockups / wireframes.
- Organization.
- GitHub repository with a comprehensive and relevant README.
- Simplonline submission with links to the various deliverables (ensure they are publicly accessible!).

## Performance Criteria

- The site adheres to the specifications.
- Expected functionalities do not produce errors.
- The site is responsive and adapts to a variety of screens.
- Files are logically divided, and assets are organized.
- The page(s) is/are functional.
- Adherence to best practices in naming, indentation, and semantics.
