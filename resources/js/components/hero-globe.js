import Globe from 'globe.gl';
import * as THREE from 'three';

/**
 * Initialize the 3D Globe for SpeedJobs Africa Hero Section
 * @param {string} elementId - The DOM element ID to render the globe
 */
export default function initGlobe(elementId, onLoaded) {
    const container = document.getElementById(elementId);
    if (!container) {
        console.error(`Element with ID "${elementId}" not found`);
        return;
    }

    // Initialize Globe
    const globe = Globe()
        (container)
        .backgroundColor('rgba(0,0,0,0)') // Transparent to show Tailwind gradients
        .showAtmosphere(true)
        .atmosphereColor('#059669') // Primary-600
        .atmosphereAltitude(0.2) // Increased atmosphere for better glow
        .width(container.offsetWidth)
        .height(container.offsetHeight);

    // Disable zoom to prevent hijacking page scroll
    globe.controls().enableZoom = false;
    globe.controls().autoRotate = true; // Enable auto-rotation
    globe.controls().autoRotateSpeed = 0.5; // Slow rotation speed

    // Shift the globe to the left by adjusting the camera view offset
    // We do this by telling the camera it's part of a larger view, and we are looking at the right part of it
    // effectively shifting the center to the left
    const updateCameraOffset = () => {
        const width = container.offsetWidth;
        const height = container.offsetHeight;
        // Shift by 5% of the width to the right
        // Negative shiftX moves the camera frame to the left, which makes the object appear to move to the right
        const shiftX = -width * 0.05;
        globe.camera().setViewOffset(width, height, shiftX, 0, width, height);
        globe.camera().updateProjectionMatrix();
    };

    // Fetch GeoJSON data (All continents)
    fetch('https://raw.githubusercontent.com/vasturiano/react-globe.gl/master/example/datasets/ne_110m_admin_0_countries.geojson')
        .then(res => res.json())
        .then(data => {
            // Use all countries data (no filter)
            const worldData = {
                type: 'FeatureCollection',
                features: data.features
            };

            // Configure globe material (Water color)
            const globeMaterial = globe.globeMaterial();
            globeMaterial.color = new THREE.Color('#1e3a8a'); // Deep Ocean Blue (Blue-900)
            globeMaterial.emissive = new THREE.Color('#172554'); // Darker Blue (Blue-950)
            globeMaterial.emissiveIntensity = 0.3; // Low intensity for depth
            globeMaterial.shininess = 0.8; // Realistic water reflection

            // Configure polygons (Land) - Lighter, more natural green
            globe
                .polygonsData(worldData.features)
                .polygonCapColor(() => '#10b981') // Emerald-500 (Lighter)
                .polygonSideColor(() => '#059669') // Emerald-600
                .polygonStrokeColor(() => '#047857') // Emerald-700
                .polygonAltitude(0.015) // Slightly more elevation
                .polygonLabel(({ properties: d }) => `
                    <div style="background: rgba(4, 120, 87, 0.95); padding: 8px 12px; border-radius: 8px; color: white; font-family: 'Outfit', sans-serif;">
                        <b>${d.ADMIN}</b>
                    </div>
                `)
                .onPolygonHover(hoverD => globe
                    .polygonCapColor(d => d === hoverD ? '#34d399' : '#10b981') // Hover: Emerald-400
                );

            // African Tech Hubs coordinates
            const techHubs = [
                { name: 'Lagos', lat: 6.5244, lng: 3.3792 },
                { name: 'Nairobi', lat: -1.2864, lng: 36.8172 },
                { name: 'Johannesburg', lat: -26.2041, lng: 28.0473 },
                { name: 'Cairo', lat: 30.0444, lng: 31.2357 },
                { name: 'Accra', lat: 5.6037, lng: -0.1870 },
                { name: 'Casablanca', lat: 33.5731, lng: -7.5898 },
                { name: 'Kigali', lat: -1.9441, lng: 30.0619 },
                { name: 'Cape Town', lat: -33.9249, lng: 18.4241 },
                { name: 'Dakar', lat: 14.7167, lng: -17.4677 },
                { name: 'Addis Ababa', lat: 9.0328, lng: 38.7419 },
                { name: 'Kampala', lat: 0.3476, lng: 32.5825 },
                { name: 'Dar es Salaam', lat: -6.7924, lng: 39.2083 },
                // Add some international connections
                { name: 'London', lat: 51.5074, lng: -0.1278 },
                { name: 'New York', lat: 40.7128, lng: -74.0060 },
                { name: 'Dubai', lat: 25.2048, lng: 55.2708 },
                { name: 'San Francisco', lat: 37.7749, lng: -122.4194 },
                { name: 'Berlin', lat: 52.5200, lng: 13.4050 }
            ];

            // Generate arcs
            const arcsData = [];
            // Internal African routes - Reduced count even further
            for (let i = 0; i < 6; i++) { // Reduced from 8
                for (let j = i + 1; j < 6; j++) {
                    if (Math.random() > 0.7) {
                        arcsData.push({
                            startLat: techHubs[i].lat,
                            startLng: techHubs[i].lng,
                            endLat: techHubs[j].lat,
                            endLng: techHubs[j].lng,
                            color: ['#F59E0B', '#D97706']
                        });
                    }
                }
            }
            // International connections (Africa to World)
            for (let i = 0; i < 12; i++) {
                for (let j = 12; j < techHubs.length; j++) {
                    if (Math.random() > 0.4) {
                        arcsData.push({
                            startLat: techHubs[i].lat,
                            startLng: techHubs[i].lng,
                            endLat: techHubs[j].lat,
                            endLng: techHubs[j].lng,
                            color: ['#3b82f6', '#60a5fa'] // Blue for global connections
                        });
                    }
                }
            }

            // Configure arcs (flight paths)
            globe
                .arcsData(arcsData)
                .arcColor('color')
                .arcDashLength(0.4)
                .arcDashGap(0.2)
                .arcDashAnimateTime(4000) // Slowed down from 2000
                .arcStroke(0.5)
                .arcAltitude(0.1)
                .arcAltitudeAutoScale(0.3);

            // Add pulsating rings at tech hubs
            globe
                .ringsData(techHubs)
                .ringColor(() => t => `rgba(16, 185, 129, ${1 - t})`) // Emerald ring fading out
                .ringMaxRadius(6)
                .ringPropagationSpeed(2)
                .ringRepeatPeriod(1000);

            // Point camera at Africa (centered view)
            // Increased altitude to 2.5 to reduce scale (move camera back)
            globe.pointOfView({ lat: 0, lng: 20, altitude: 2.5 }, 1000);

            // Apply camera offset after pointOfView might have reset things (though pointOfView animates, so we might need to re-apply or just set it)
            updateCameraOffset();

            // Add custom Three.js lighting for heroic effect
            const scene = globe.scene();

            // Clear existing lights if any (to prevent accumulation on re-renders)
            scene.children = scene.children.filter(obj => !(obj instanceof THREE.Light));

            // Ambient light for overall illumination
            const ambientLight = new THREE.AmbientLight(0xffffff, 1.2); // Increased from 0.8
            scene.add(ambientLight);

            // Directional light positioned for warm sunlight rim effect
            const directionalLight = new THREE.DirectionalLight(0xF59E0B, 2.0); // Increased intensity from 1.5
            directionalLight.position.set(100, 100, 50);
            scene.add(directionalLight);

            // Blue backlight for water depth
            const backLight = new THREE.DirectionalLight(0x1E3A8A, 1.5); // Increased from 1.2
            backLight.position.set(-100, -100, -50);
            scene.add(backLight);

            // Call onLoaded callback if provided
            if (onLoaded && typeof onLoaded === 'function') {
                // Small delay to ensure the first frame renders
                setTimeout(() => {
                    onLoaded();
                }, 100);
            }
        })
        .catch(error => {
            console.error('Error loading GeoJSON data:', error);
            // Even on error, we might want to show what we have or handle it
            if (onLoaded && typeof onLoaded === 'function') {
                onLoaded();
            }
        });

    // Handle window resize
    const handleResize = () => {
        if (container) {
            globe
                .width(container.offsetWidth)
                .height(container.offsetHeight);
            updateCameraOffset();
        }
    };

    window.addEventListener('resize', handleResize);

    // Cleanup function
    return () => {
        window.removeEventListener('resize', handleResize);
    };
}

