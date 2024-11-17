<template>
    <Head title="Edit Resume" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Resume</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <!-- Resume Form -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column: Form -->
                        <div class="space-y-6">
                            <div>
                                <InputLabel for="title" value="Resume Title" />
                                <TextInput
                                    id="title"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.title"
                                />
                            </div>

                            <!-- Personal Information -->
                            <div v-if="form.content?.sections?.[0]">
                                <h3 class="font-bold text-lg mb-4">Personal Information</h3>
                                <div class="space-y-4">
                                    <div v-for="(value, key) in form.content.sections[0].content" :key="key">
                                        <InputLabel :for="key" :value="formatLabel(key)" />
                                        <TextInput
                                            :id="key"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="form.content.sections[0].content[key]"
                                        />
                                    </div>
                                </div>
                            </div>

                            <!-- Other Sections -->
                            <div v-for="(section, index) in form.content?.sections?.slice(1)" 
                                :key="section.type" 
                                class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <h3 class="font-bold text-lg">{{ section.title }}</h3>
                                    <button 
                                        type="button"
                                        @click="addItem(section.type)"
                                        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                                    >
                                        Add {{ formatLabel(section.type) }}
                                    </button>
                                </div>

                                <div v-if="Array.isArray(section.content)" class="space-y-6">
                                    <div v-for="(item, itemIndex) in section.content" 
                                        :key="itemIndex"
                                        class="p-4 border rounded relative">
                                        <!-- Remove button -->
                                        <button 
                                            @click="removeItem(section.type, itemIndex)"
                                            class="absolute top-2 right-2 text-red-500 hover:text-red-700"
                                            type="button"
                                        >
                                            Remove
                                        </button>

                                        <!-- Education Fields -->
                                        <template v-if="section.type === 'education'">
                                            <div class="space-y-4">
                                                <div>
                                                    <InputLabel for="school" value="School" />
                                                    <TextInput
                                                        id="school"
                                                        v-model="item.school"
                                                        type="text"
                                                        class="mt-1 block w-full"
                                                        placeholder="Enter school name"
                                                    />
                                                </div>
                                                <div>
                                                    <InputLabel for="degree" value="Degree" />
                                                    <TextInput
                                                        id="degree"
                                                        v-model="item.degree"
                                                        type="text"
                                                        class="mt-1 block w-full"
                                                        placeholder="Enter degree"
                                                    />
                                                </div>
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <InputLabel for="startDate" value="Start Date" />
                                                        <TextInput
                                                            id="startDate"
                                                            v-model="item.startDate"
                                                            type="text"
                                                            class="mt-1 block w-full"
                                                            placeholder="MM/YYYY"
                                                        />
                                                    </div>
                                                    <div>
                                                        <InputLabel for="endDate" value="End Date" />
                                                        <TextInput
                                                            id="endDate"
                                                            v-model="item.endDate"
                                                            type="text"
                                                            class="mt-1 block w-full"
                                                            placeholder="MM/YYYY or Present"
                                                        />
                                                    </div>
                                                </div>
                                                <div>
                                                    <InputLabel for="description" value="Description" />
                                                    <textarea
                                                        v-model="item.description"
                                                        rows="3"
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                        placeholder="Enter description"
                                                    ></textarea>
                                                </div>
                                            </div>
                                        </template>

                                        <!-- Experience Fields -->
                                        <template v-else-if="section.type === 'experience'">
                                            <div class="space-y-4">
                                                <div>
                                                    <InputLabel for="company" value="Company" />
                                                    <TextInput
                                                        id="company"
                                                        v-model="item.company"
                                                        type="text"
                                                        class="mt-1 block w-full"
                                                        placeholder="Enter company name"
                                                    />
                                                </div>
                                                <div>
                                                    <InputLabel for="position" value="Position" />
                                                    <TextInput
                                                        id="position"
                                                        v-model="item.position"
                                                        type="text"
                                                        class="mt-1 block w-full"
                                                        placeholder="Enter position"
                                                    />
                                                </div>
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <InputLabel for="startDate" value="Start Date" />
                                                        <TextInput
                                                            id="startDate"
                                                            v-model="item.startDate"
                                                            type="text"
                                                            class="mt-1 block w-full"
                                                            placeholder="MM/YYYY"
                                                        />
                                                    </div>
                                                    <div>
                                                        <InputLabel for="endDate" value="End Date" />
                                                        <TextInput
                                                            id="endDate"
                                                            v-model="item.endDate"
                                                            type="text"
                                                            class="mt-1 block w-full"
                                                            placeholder="MM/YYYY or Present"
                                                        />
                                                    </div>
                                                </div>
                                                <div>
                                                    <InputLabel for="description" value="Description" />
                                                    <textarea
                                                        v-model="item.description"
                                                        rows="3"
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                        placeholder="Enter job description"
                                                    ></textarea>
                                                </div>
                                            </div>
                                        </template>

                                        <!-- Skills Fields -->
                                        <template v-else-if="section.type === 'skills'">
                                            <div>
                                                <InputLabel for="skill" value="Skill" />
                                                <TextInput
                                                    id="skill"
                                                    v-model="item.skill"
                                                    type="text"
                                                    class="mt-1 block w-full"
                                                    placeholder="Enter skill"
                                                />
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end space-x-4">
                                <PrimaryButton @click="save" :disabled="form.processing">Save</PrimaryButton>
                                <PrimaryButton @click="generatePDF" :disabled="form.processing">Export PDF</PrimaryButton>
                            </div>
                        </div>

                        <!-- Right Column: Preview -->
                        <div class="relative">
                            <div id="resume-preview" class="bg-white shadow-lg p-8 min-h-[800px]" ref="previewContainer">
                                <div v-html="currentTemplate.render()"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref, computed, onMounted, watch } from 'vue';
import draggable from 'vuedraggable';
import html2canvas from 'html2canvas';
import jsPDF from 'jspdf';

// Define default content structure first
const defaultContent = {
    sections: [
        {
            type: 'personal',
            title: 'Personal Information',
            content: {
                name: '',
                email: '',
                phone: '',
                address: ''
            }
        },
        {
            type: 'education',
            title: 'Education',
            content: []
        },
        {
            type: 'experience',
            title: 'Work Experience',
            content: []
        },
        {
            type: 'skills',
            title: 'Skills',
            content: []
        }
    ]
};

const props = defineProps({
    resume: {
        type: Object,
        required: true
    }
});

// Initialize form with default content
const form = useForm({
    title: props.resume?.title || '',
    template: props.resume?.template || 'modern',
    content: props.resume?.content ? JSON.parse(JSON.stringify(props.resume.content)) : JSON.parse(JSON.stringify(defaultContent))
});

console.log('Initial form content:', form.content);

const previewContent = ref(null);

// Add a watcher to update preview content when form changes
watch(() => form.content, (newContent) => {
    console.log('Form content updated:', newContent);
    previewContent.value = newContent;
}, { deep: true });

const resumeData = computed(() => {
    // Ensure we have valid content structure
    if (!form.content || !form.content.sections) {
        console.log('Initializing with default content');
        return {
            personal: defaultContent.sections[0].content,
            sections: defaultContent.sections.slice(1)
        };
    }

    const sections = form.content.sections;
    const personalSection = sections[0]?.content || defaultContent.sections[0].content;
    const otherSections = sections.slice(1) || defaultContent.sections.slice(1);

    console.log('Computed resumeData:', {
        personal: personalSection,
        sections: otherSections
    });

    return {
        personal: personalSection,
        sections: otherSections
    };
});

const currentTemplate = computed(() => {
    if (!resumeData.value) {
        console.log('No resume data available');
        return {
            render: () => '<div class="resume-content">Loading...</div>'
        };
    }

    // Get the current resume data
    const { personal, sections } = resumeData.value;
    
    if (!personal) {
        console.log('No personal data available');
        return {
            render: () => '<div class="resume-content">Loading personal information...</div>'
        };
    }

    console.log('Rendering template with data:', { personal, sections });

    // Return the template based on form.template
    return {
        render: () => `
            <div class="resume-content">
                <div class="personal-info text-center mb-8">
                    <h1 class="text-3xl font-bold">${personal.name || 'Your Name'}</h1>
                    <p class="text-gray-600">${personal.email || 'email@example.com'}</p>
                    <p class="text-gray-600">${personal.phone || 'Phone Number'}</p>
                    <p class="text-gray-600">${personal.address || 'Address'}</p>
                </div>
                ${sections.map(section => `
                    <div class="resume-section mb-8">
                        <h2 class="text-2xl font-bold border-b-2 border-gray-300 mb-4 pb-2">${section.title}</h2>
                        ${Array.isArray(section.content) ? section.content.map(item => `
                            <div class="section-item mb-4">
                                ${Object.entries(item).map(([key, value]) => `
                                    <p class="mb-1"><strong class="text-gray-700">${formatLabel(key)}:</strong> ${value}</p>
                                `).join('')}
                            </div>
                        `).join('') : ''}
                    </div>
                `).join('')}
            </div>
        `
    };
});

const formatLabel = (key) => {
    return key.charAt(0).toUpperCase() + key.slice(1).replace(/([A-Z])/g, ' $1');
};

const getEmptyItem = (type) => {
    switch (type) {
        case 'education':
            return {
                school: '',
                degree: '',
                startDate: '',
                endDate: '',
                description: ''
            };
        case 'experience':
            return {
                company: '',
                position: '',
                startDate: '',
                endDate: '',
                description: ''
            };
        case 'skills':
            return { skill: '' };
        default:
            return {};
    }
};

const addItem = (type) => {
    console.log('Adding item to section:', type);
    const section = form.content.sections.find(s => s.type === type);
    if (section) {
        if (!Array.isArray(section.content)) {
            section.content = [];
        }
        const newItem = getEmptyItem(type);
        console.log('Adding new item:', newItem);
        section.content.push(newItem);
    }
};

const removeItem = (sectionType, index) => {
    const section = form.content.sections.find(s => s.type === sectionType);
    if (section && Array.isArray(section.content)) {
        section.content.splice(index, 1);
    }
};

const save = () => {
    form.put(route('resumes.update', props.resume.id));
};

const generatePDF = async () => {
    try {
        console.log('Starting PDF generation...');
        
        // Wait a bit for the template to render
        await new Promise(resolve => setTimeout(resolve, 500));

        const previewContainer = document.querySelector('#resume-preview');
        console.log('Preview container:', previewContainer);
        
        if (!previewContainer) {
            console.error('Resume preview container not found');
            return;
        }

        const resumeContent = previewContainer.querySelector('.resume-content');
        console.log('Resume content element:', resumeContent);

        if (!resumeContent) {
            console.error('Resume content element not found');
            return;
        }

        // Log the current state
        console.log('Current resume data:', resumeData.value);
        console.log('Element to capture:', resumeContent);
        console.log('HTML content:', resumeContent.innerHTML);

        const canvas = await html2canvas(resumeContent, {
            scale: 2,
            useCORS: true,
            logging: true,
            backgroundColor: '#ffffff',
            onclone: function(clonedDoc) {
                const clonedElement = clonedDoc.querySelector('.resume-content');
                console.log('Cloned element:', clonedElement);
                return clonedElement;
            }
        });

        const pdf = new jsPDF({
            orientation: 'portrait',
            unit: 'px',
            format: 'a4'
        });

        const imgData = canvas.toDataURL('image/png');
        const imgProps = pdf.getImageProperties(imgData);
        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

        pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
        pdf.save(`${form.title || 'resume'}.pdf`);
    } catch (error) {
        console.error('Error generating PDF:', error);
        console.error('Error details:', {
            resumeData: resumeData.value,
            form: form
        });
    }
};

onMounted(() => {
    console.log('Component mounted');
    console.log('Props:', props);
});
</script>

<style>
.resume-preview {
    max-width: 8.5in;
    margin: 0 auto;
    padding: 0.5in;
}
</style>
