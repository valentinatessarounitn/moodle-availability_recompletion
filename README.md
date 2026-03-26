moodle-availability_recompletion
========================

Moodle availability plugin which lets users restrict resources, activities and sections based on recompletion of the selected course.


Requirements
------------

This plugin requires Moodle 4.1+.   
This plugin requires the plugin Course recompletion [local_recompletion](https://moodle.org/plugins/local_recompletion).  


Motivation for this plugin
--------------------------

The plugin Course recompletion [local_recompletion](https://moodle.org/plugins/local_recompletion) allows clearing all course and activity completion for a user based on the duration set notifying the student they need to return to the course and recomplete it.

The problem is that, once the completion is removed, it is no longer possible to distinguish between users who have never completed the course and users who have completed the course but their completion has been removed.

This plugin allows you to:
- show or hide elements only for users who have never completed the course
- show or hide elements only for users who have completed the course and their completion has been removed.


Installation
------------

Install the plugin like any other plugin to folder moodle/availability/condition/recompletion.   

The folder structure should therefore be:
```
| moodle
  |-- availability
    |-- condition
      |-- recompletion
        |-- classes
        |-- lang
        |-- tests
        |-- yui
        ...                
```      

After installing the plugin, it is ready to use without the need for any configuration.   

See http://docs.moodle.org/en/Installing_plugins for details on installing Moodle plugins


List of selectable courses
--------------------------

A course X is present in the dropdown menu in 'Settings / Restrict access' if:
- recompletion has been enabled for course X
- there is at least one user of course X whose completion has been removed using the plugin [Course recompletion](https://moodle.org/plugins/local_recompletion)


Dependencies 
------------

The plugin [local_recompletion](https://moodle.org/plugins/local_recompletion) records all the data in tables whose names start with `local_recompletion_`.

This plugin only reads the data present in the `local_recompletion_cc` and `local_recompletion_config` tables.
If in the future the table used by the local_recompletion plugin changes then must be modified the two queries present in the methods:   
- class condition, function is_available
- class frontend, function get_javascript_init_params


Example
-------

### EN

Let's assume we have created a `course A` that generates a certificate/badge valid for 2 years and we decide to automatically cancel the course completion after 2 years using the [Course recompletion](https://moodle.org/plugins/local_recompletion) plugin.     
The cancellation of `course A` allows us to have an updated report of the students who still have that course valid.

After the cancellation of the course, we might want to:
- prevent the repetition of `course A` and/or
- show different activities within `course A` and/or
- provide a `course B` with update activities reserved only for students who had completed `course A`.

By enabling the `Archive completion data` flag in the [Course recompletion](https://moodle.org/plugins/local_recompletion) plugin for `course A`, the data on canceled completions is archived in a separate table. However, it is not possible to interact with this data from the Moodle interface and, in particular, it is not possible to activate completion conditions.

This plugin helps us by allowing us to distinguish between users who have never completed the course and those who have completed the course at least once but whose completion has expired, based on the archived recompletion data.   
It is therefore possible to set activities/resources/sections of the course with visibility conditioned by the canceled completion of the course.

For example, if the student has never completed `course A` or has completed it but it has not expired:
- they should be able to see the contents of `course A`;
- the contents of the update `course B` are hidden;
- an informative text area could be inserted in `course B` indicating to the student the need to refer to `course A`.

Or, if the student has completed `course A` but the completion has expired:
- they should be able to see the contents of `course B`;
- some activities/resources of `course A` (e.g., final quiz, certificate) should be hidden;
- an informative text area could be inserted in `course A` indicating to the student the link to enroll in the update `course B`.

All the configuration hypothesized here for courses A and B could be thought of in a single course, adding the sections of `course B` directly into `course A` and showing the contents of the base course and the update course based on the described conditions.    
The choice of whether to create two separate courses or a single course could be made, for example, based on:
- educational issues (e.g., different teachers);
- not overloading a course if there is a lot of content;
- if we want different reporting between those who have taken the base course and those who have taken the update;
- if we want to issue different badges depending on the type of course completed.

### IT
 
Ipotizziamo di avere creato un `corso A` che genera un certificato/badge valevole per 2 anni e decidiamo di annullare automaticamente dopo 2 anni il completamento del corso tramite plugin [Course recompletion](https://moodle.org/plugins/local_recompletion).     
L'annullamento del `corso A` ci permette di avere un report aggiornato degli studenti che hanno quel corso ancora valido.

Dopo l'annullamento, del corso potremmo voler:
- impedire la ripetizione del `corso A` e/o
- mostrare delle attività differenti all'interno del `corso A` e/o
- mettere a disposizione un `corso B` con delle attività di aggiornamento riservate ai soli studenti che avevano completato il `corso A`.

Attivando il flag `Archive completion data` nel plugin [Course recompletion](https://moodle.org/plugins/local_recompletion) del `corso A`, i dati sui completamenti annullati vengono archiviati in una tabella separata. Non è però possibile interagire su questi dati da interfaccia Moodle e in particolare non è possibile attivare delle condizioni di completamento.

Ci viene quindi in aiuto questo plugin, il quale, basandosi sui dati dati di ricompletamento archiviati, permette di distinguere tra gli utenti che non hanno mai completato il corso e quelli che hanno già completato il corso almeno una volta ma il cui completamento è scaduto.   
E' quindi possibile impostare delle attività/risorse/sezioni del corso con visibilità condizionata dal completamento annullato del corso.

Per esempio, se lo studente non ha mai completato il `corso A` o lo ha completato ma non è scaduto:
- deve poter poter vedere i contenuti del `corso A`;
- i contenuti del corso di aggiornamento B vengono nascosti;
- nel `corso B` potrebbe essere inserita un'area di testo informativa che indica allo studente la necessità di fare riferimento al `corso A`.

Oppure, se lo studente ha completato il `corso A` ma il completamento è scaduto:
- deve poter poter vedere i contenuti del `corso B`;
- alcune attività/risorse del `corso A` (es. Quiz finale, certificato) vanno nascoste;
- nel `corso A` potrebbe essere inserita un'area di testo informativa che indica allo studente il link per iscriversi al corso di aggiornamento B.

Tutta la configurazione qui ipotizzata per il `corso A` e B potrebbe essere pensata in un unico corso, aggiungendo le sezioni del `corso B` direttamente nel `corso A` e mostrando i contenuti del corso base e i contenuti del corso di aggiornamento in funzione delle descritte condizioni.    
La scelta se creare due corsi distinti o un unico corso potrebbe essere fatta ad esempio in base a:
- questioni didattiche (es. docenti differenti);
- per non appesantire troppo un corso se ci sono molti contenuti;
- se vogliamo una reportistica differente fra chi ha fatto il corso base e chi l'aggiornamento;
- se vogliamo erogare dei badge differenti in funzione del tipo di corso completato.
