graph TD
    %% Les Tables (Nœuds)
    User(USER <br> Utilisateurs)
    Category(CATEGORY <br> Catégories)
    Expense(EXPENSE <br> Dépenses)
    Part(EXPENSE_PARTICIPANT <br> Participants)
    Reimb(REIMBURSEMENT <br> Remboursements)

    %% Les Relations (Flèches)
    User -- Crée et Paye --> Expense
    Category -- Définit le type --> Expense
    
    Expense -- Se compose de --> Part
    User -- Est inclus dans --> Part
    
    User -- Envoie l'argent --> Reimb
    User -- Reçoit l'argent --> Reimb

    %% Styles (Optionnel pour faire joli)
    style User fill:#f9f,stroke:#333,stroke-width:2px
    style Expense fill:#bbf,stroke:#333,stroke-width:2px
    style Reimb fill:#bfb,stroke:#333,stroke-width:2px