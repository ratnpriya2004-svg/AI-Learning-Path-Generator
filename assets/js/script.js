// ======================================
// AI Learning Path Generator
// script.js
// ======================================

document.addEventListener("DOMContentLoaded", function () {


    // ==================================
    // FAQ
    // ==================================

    const faqItems =
        document.querySelectorAll(".faq-item");


    faqItems.forEach(function (item) {

        const btn =
            item.querySelector(".faq-question");


        if (btn) {

            btn.addEventListener(
                "click",
                function () {

                    item.classList.toggle(
                        "active"
                    );

                }
            );

        }

    });



    // ==================================
    // COUNTERS
    // ==================================

    const counters =
        document.querySelectorAll(".counter");


    counters.forEach(function (counter) {

        const target =
            parseInt(
                counter.getAttribute(
                    "data-target"
                )
            ) || 0;


        let count = 0;

        const speed =
            Math.max(
                1,
                target / 100
            );


        function updateCounter() {

            if (count < target) {

                count += speed;

                counter.innerText =
                    Math.ceil(count);

                requestAnimationFrame(
                    updateCounter
                );

            } else {

                counter.innerText =
                    target;

            }

        }


        updateCounter();

    });



    // ==================================
    // GEMINI AI DEMO
    // ==================================

    const demoForm =
        document.getElementById(
            "demoForm"
        );


    const demoOutput =
        document.querySelector(
            ".demo-output"
        );


    const generateBtn =
        document.getElementById(
            "generateRoadmapBtn"
        );


    if (
        !demoForm ||
        !demoOutput ||
        !generateBtn
    ) {

        console.log(
            "AI Demo elements not found."
        );

        return;

    }



    // ==================================
    // FORM SUBMIT
    // ==================================

    demoForm.addEventListener(
        "submit",
        async function (event) {

            event.preventDefault();


            // ------------------------------
            // GET VALUES
            // ------------------------------

            const goal =
                document.getElementById(
                    "demoGoal"
                ).value.trim();


            const skill =
                document.getElementById(
                    "demoLevel"
                ).value;


            const study =
                document.getElementById(
                    "demoStudy"
                ).value;


            const duration =
                document.getElementById(
                    "demoDuration"
                ).value;



            // ------------------------------
            // VALIDATE
            // ------------------------------

            if (
                !goal ||
                !skill ||
                !study ||
                !duration
            ) {

                alert(
                    "Please fill all learning details."
                );

                return;

            }



            // ------------------------------
            // BUTTON LOADING
            // ------------------------------

            generateBtn.disabled = true;


            generateBtn.innerHTML = `

                <i class="fa-solid fa-spinner fa-spin"></i>

                Generating with AI...

            `;



            // ------------------------------
            // OUTPUT LOADING
            // ------------------------------

            demoOutput.innerHTML = `

                <div
                    style="
                        text-align:center;
                        padding:40px 20px;
                    "
                >

                    <i
                        class="fa-solid fa-brain fa-spin"
                        style="
                            font-size:40px;
                            color:#4F46E5;
                            margin-bottom:15px;
                        "
                    ></i>


                    <h3>
                        AI is creating your roadmap...
                    </h3>


                    <p
                        style="
                            color:#6B7280;
                            margin-top:10px;
                        "
                    >
                        Analyzing your goal,
                        skill level and study time.
                    </p>

                </div>

            `;



            try {


                // --------------------------
                // SEND DATA
                // --------------------------

                const formData =
                    new FormData();


                formData.append(
                    "goal",
                    goal
                );


                formData.append(
                    "skill",
                    skill
                );


                formData.append(
                    "study",
                    study
                );


                formData.append(
                    "duration",
                    duration
                );



                // --------------------------
                // PHP REQUEST
                // --------------------------

                const response =
                    await fetch(
                        "php/demo_ai.php",
                        {
                            method: "POST",
                            body: formData
                        }
                    );



                const data =
                    await response.json();



                console.log(
                    "Gemini Demo Response:",
                    data
                );



                // --------------------------
                // CHECK ERROR
                // --------------------------

                if (
                    !response.ok ||
                    !data.success
                ) {

                    throw new Error(
                        data.message ||
                        "AI generation failed."
                    );

                }



                // --------------------------
                // BUILD ROADMAP
                // --------------------------

                let html = "";


                data.roadmap.forEach(
                    function (step, index) {

                        html += `

                            <div
                                class="week"
                            >

                                <span>
                                    Step ${index + 1}
                                </span>


                                <h4>

                                    ${escapeHTML(
                                        step.title
                                    )}

                                </h4>


                                <p>

                                    ${escapeHTML(
                                        step.description
                                    )}

                                </p>


                                <small>

                                    <i
                                        class="fa-solid fa-clock"
                                    ></i>

                                    ${escapeHTML(
                                        step.duration
                                    )}

                                </small>

                            </div>

                        `;

                    }
                );



                // --------------------------
                // SHOW RESULT
                // --------------------------

                demoOutput.innerHTML = `

                    <h3>
                        Your AI Learning Plan
                    </h3>


                    <div
                        class="roadmap-info"
                    >

                        <p>
                            <strong>Goal:</strong>
                            ${escapeHTML(goal)}
                        </p>


                        <p>
                            <strong>Level:</strong>
                            ${escapeHTML(skill)}
                        </p>


                        <p>
                            <strong>Daily Study:</strong>
                            ${escapeHTML(study)}
                        </p>


                        <p>
                            <strong>Duration:</strong>
                            ${escapeHTML(duration)}
                        </p>

                    </div>


                    <div
                        class="roadmap-card"
                    >

                        ${html}

                    </div>


                    <div
                        class="demo-success"
                    >

                        <i
                            class="fa-solid fa-circle-check"
                        ></i>

                        Your personalized AI roadmap
                        is ready! 🚀

                    </div>

                `;



            } catch (error) {


                console.error(
                    "Gemini Error:",
                    error
                );


                demoOutput.innerHTML = `

                    <div
                        style="
                            text-align:center;
                            padding:30px;
                        "
                    >

                        <i
                            class="
                                fa-solid
                                fa-triangle-exclamation
                            "
                            style="
                                font-size:35px;
                                color:#dc2626;
                            "
                        ></i>


                        <h3>
                            Unable to generate roadmap
                        </h3>


                        <p
                            style="
                                color:#6B7280;
                                margin-top:10px;
                            "
                        >
                            ${escapeHTML(
                                error.message
                            )}
                        </p>

                    </div>

                `;

            }



            // ------------------------------
            // RESTORE BUTTON
            // ------------------------------

            generateBtn.disabled = false;


            generateBtn.innerHTML = `

                <i
                    class="
                        fa-solid
                        fa-wand-magic-sparkles
                    "
                ></i>

                Generate AI Roadmap

            `;

        }
    );

});



// ======================================
// ESCAPE HTML
// ======================================

function escapeHTML(value) {

    const div =
        document.createElement(
            "div"
        );


    div.textContent =
        value ?? "";


    return div.innerHTML;

}